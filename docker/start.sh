#!/bin/sh
set -e

cd /var/www/html

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force || echo "Migration failed, continuing..."

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage symlink
php artisan storage:link || true

# Hand off to the base image's entrypoint (starts php-fpm + nginx)
exec /init
