FROM php:7.2-apache
RUN apt-get update && apt-get install -y
RUN apt-get update && apt-get install -y --no-install-recommends \
    git zlib1g-dev libxml2-dev libzip-dev \
    && docker-php-ext-install \
       zip intl mysqli pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php && mv /var/www/html/composer.phar /usr/local/bin/composer
COPY . /var/www/html/
RUN adduser user
USER user
