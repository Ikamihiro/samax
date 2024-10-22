FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www

RUN chown -R www-data:www-data /var/www

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY start-apache /usr/local/bin
RUN a2enmod rewrite


CMD ["start-apache"]