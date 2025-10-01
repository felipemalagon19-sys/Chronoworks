FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y libpq-dev unzip && \
    docker-php-ext-install pdo_pgsql pgsql

COPY ./ /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
RUN a2enmod rewrite

CMD ["apache2-foreground"]