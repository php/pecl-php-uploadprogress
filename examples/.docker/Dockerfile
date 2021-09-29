ARG php_version
FROM php:${php_version}-fpm

ARG uploadprogress_version

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY uploadprogress.ini $PHP_INI_DIR/conf.d/

RUN pecl install uploadprogress-${uploadprogress_version} \
    && docker-php-ext-enable uploadprogress
