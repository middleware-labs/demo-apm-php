# Pull in dependencies with composer
FROM composer:2.5 as build
COPY composer.json ./
RUN composer install --ignore-platform-reqs

FROM wordpress:latest

# Install dependencies
RUN pecl install opentelemetry protobuf

RUN  bash -c `echo "auto_prepend_file=/var/www/otel/autoload.php" | tee -a /usr/local/etc/php/php.ini && echo "extension=opentelemetry.so" | tee -a /usr/local/etc/php/php.ini && echo "extension=protobuf.so" | tee -a /usr/local/etc/php/php.ini`

# Copy in the composer vendor files and autoload.php
COPY --from=build /app/vendor /var/www/otel
