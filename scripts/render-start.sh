#!/usr/bin/env sh
set -e

APP_KEY_FILE="/var/www/html/storage/app/.appkey"

if [ -z "$APP_KEY" ]; then
    if [ -f "$APP_KEY_FILE" ]; then
        echo "APP_KEY is missing; reusing the persisted key from a previous boot."
        export APP_KEY="$(cat "$APP_KEY_FILE")"
    else
        echo "APP_KEY is missing; generating a key and persisting it for future boots."
        export APP_KEY="$(php artisan key:generate --show --no-ansi)"
        mkdir -p "$(dirname "$APP_KEY_FILE")"
        printf '%s' "$APP_KEY" > "$APP_KEY_FILE"
    fi
fi

if [ -z "${APP_URL:-}" ] && [ -n "${RENDER_EXTERNAL_URL:-}" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

if [ "${DB_CONNECTION:-}" = "pgsql" ] && [ -z "${DB_URL:-}" ] && [ -z "${DATABASE_URL:-}" ]; then
    echo "Postgres URL is missing; falling back to SQLite for this deployment."
    export DB_CONNECTION=sqlite
    export DB_DATABASE=/var/www/html/database/database.sqlite
fi

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    mkdir -p database
    touch "${DB_DATABASE:-/var/www/html/database/database.sqlite}"
fi

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan storage:link || true

if ! php artisan migrate --force; then
    echo "Primary database migration failed; falling back to SQLite for this instance."
    export DB_CONNECTION=sqlite
    export DB_DATABASE=/var/www/html/database/database.sqlite
    touch "$DB_DATABASE"
    php artisan config:clear
    php artisan migrate --force
fi

php artisan db:seed --force
php artisan firebase:sync || echo "Firebase sync failed; continuing startup."

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Queue worker in the same container (Render free plan has no separate worker
# service). The loop restarts it after the hourly recycle or a crash.
(
    while true; do
        php artisan queue:work --tries=3 --backoff=10 --max-time=3600 || true
        sleep 2
    done
) &

exec php -S 0.0.0.0:"${PORT:-10000}" -t public scripts/render-router.php
