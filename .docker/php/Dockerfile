FROM php:8.1-fpm

RUN apt update && apt -y --no-install-recommends install git zlib1g-dev libzip-dev unzip
RUN docker-php-ext-install pdo pdo_mysql mysqli zip
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer;

WORKDIR /var/www/html

CMD ["sh", "-c", "composer install --prefer-dist && composer dump-autoload && php bin/console doctrine:schema:update --no-interaction --force && php-fpm -F"]