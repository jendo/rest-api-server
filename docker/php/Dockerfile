FROM php:8.2.28-fpm

ARG APP_WORK_DIR=/project
ARG COMPOSER_VERSION=2.3.10
ARG COMPOSER_SHA256=d808272f284fa8e0f8b470703e1438ac8f362030bbc9d12e29530277d767aff0

RUN \
 usermod -u 1000 www-data && \
 groupmod -g 1000 www-data && \
 usermod -d /home/www-data -m -s /bin/bash www-data && \
 chown -R www-data:www-data /home/www-data

RUN \
 apt-get update && \
 apt-get install -y vim git curl zip unzip

RUN curl -Ls "https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar" > /usr/local/bin/composer && \
    test "$(sha256sum /usr/local/bin/composer | cut -d ' ' -f 1)" = "${COMPOSER_SHA256}" && \
    chmod +x /usr/local/bin/composer && \
    chown www-data:www-data /usr/local/bin/composer

# xdebug
RUN pecl install xdebug-3.2.2

# PDO MYSQL
RUN docker-php-ext-install pdo_mysql

# pcntl
RUN docker-php-ext-install pcntl

# Setup environment
ENV DEV=1
RUN mkdir -p $APP_WORK_DIR
RUN chmod -R 755 $APP_WORK_DIR
RUN chown -R www-data:www-data $APP_WORK_DIR

# Copy the entrypoint script into the image
COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set the entrypoint to the entrypoint.sh script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

WORKDIR $APP_WORK_DIR
