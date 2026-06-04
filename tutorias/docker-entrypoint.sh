#!/bin/bash
set -e

PORT=${PORT:-8080}
sed -i "s/\${PORT}/$PORT/g" /etc/nginx/nginx.conf

php artisan storage:link --force 2>/dev/null || true

if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "SomeRandomString" ]; then
    php artisan key:generate --force
fi

php artisan optimize

php-fpm -D

nginx -g "daemon off;"
