FROM php:8.2-cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev zip unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install opcache pdo pdo_mysql

WORKDIR /app
COPY . /app

RUN composer install

COPY docker/symfony /usr/local/bin/symfony

EXPOSE 8000
CMD symfony local:server:start