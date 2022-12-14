FROM php:7.4-apache AS builder
# RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev libzip-dev unzip  && docker-php-ext-install pdo pdo_mysql && docker-php-ext-install zip
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_mysql
# RUN cd ~
# RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
# RUN HASH=`curl -sS https://composer.github.io/installer.sig`
# RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
# ENV COMPOSER_ALLOW_SUPERUSER=1
# RUN set -eux;
# USER php:php
WORKDIR /app
# # RUN composer install
COPY / /var/www/html