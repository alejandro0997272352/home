FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libgd-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_pgsql mbstring xml bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY tutorias/ /var/www/html
WORKDIR /var/www/html

RUN mkdir -p bootstrap/cache storage && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install --optimize-autoloader --no-dev --ignore-platform-req=ext-gd --ignore-platform-req=ext-zip

COPY nginx.conf /etc/nginx/nginx.conf
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
