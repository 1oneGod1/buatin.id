#!/usr/bin/env sh
set -e

if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is missing. Generate one with: php artisan key:generate --show"
    exit 1
fi

mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan storage:link || true

php artisan migrate --force
php artisan db:seed --force
php artisan firebase:sync

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
