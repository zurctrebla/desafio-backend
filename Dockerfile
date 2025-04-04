FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000