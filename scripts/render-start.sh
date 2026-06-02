#!/usr/bin/env sh
set -e

if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is missing; generating an ephemeral key for this instance."
    export APP_KEY="$(php artisan key:generate --show --no-ansi)"
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

exec php -S 0.0.0.0:"${PORT:-10000}" -t public scripts/render-router.php
