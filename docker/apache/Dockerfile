FROM php:7.2-apache
RUN a2enmod rewrite

RUN apt-get update \
  && apt-get install -y libzip-dev git wget --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo mysqli pdo_mysql zip;

RUN curl -sS https://getcomposer.org/installer | php && mv /var/www/html/composer.phar /usr/local/bin/composer

RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN apt update
RUN apt install symfony-cli

COPY . /var/www/html/
COPY 000-default.conf /etc/apache2/sites-available

RUN a2enmod rewrite && service apache2 restart
RUN adduser user
USER user
