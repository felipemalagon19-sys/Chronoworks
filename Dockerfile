# Dockerfile para Chronoworks
FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && \
    apt-get install -y libpq-dev unzip && \
    docker-php-ext-install pdo_pgsql pgsql

# Copia el código fuente al contenedor
COPY ./ /var/www/html

# Da permisos de escritura a Apache
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80
EXPOSE 80

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite

# Configuración recomendada para Apache
COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

# Instrucción de inicio
CMD ["apache2-foreground"]
