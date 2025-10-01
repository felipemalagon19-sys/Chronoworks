FROM php:8.2-apache

# Habilitar extensiones necesarias para PostgreSQL (Supabase)
RUN docker-php-ext-install pgsql pdo_pgsql

# Copiar todo tu proyecto al root de Apache
COPY . /var/www/html/

# Dar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html