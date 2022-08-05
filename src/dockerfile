FROM php:8.1.0-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html

RUN php artisan serve --host=172.17.0.10 --port=9001 &