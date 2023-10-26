FROM --platform=${BUILDPLATFORM:-linux/arm64} php:8.2-cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev zip unzip qemu-user-static
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install opcache pdo pdo_mysql

WORKDIR /app
COPY . /app

RUN composer install

COPY docker/symfony /usr/local/bin/symfony
RUN chmod +rwx /usr/local/bin/symfony

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +rwx /usr/local/bin/entrypoint

EXPOSE 8000
ENTRYPOINT entrypoint
#CMD symfony local:server:start
