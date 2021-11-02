FROM composer:1.9.0 as build
WORKDIR /app
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY artisan artisan
COPY . .

RUN composer update
RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist



FROM php:7.4-fpm
RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80
EXPOSE 8080
COPY --from=build /app /var/www/
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .env.example /var/www/.env
RUN chmod 777 -R /var/www/storage/ && \
    echo "Listen 8080" >> /etc/apache2/ports.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]