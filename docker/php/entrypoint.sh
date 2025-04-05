#!/bin/sh

echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
echo "xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
echo "${XDEBUG_CONFIG}" | tr " " "\n" | sed 's/^/xdebug./' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# start the main service
php-fpm
