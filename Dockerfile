FROM php:8.2-apache

RUN apt-get update && apt-get install -y libpq-dev unzip curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html/public

# Configure Apache pour servir le dossier public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/public/uploads && chmod -R 777 /var/www/html/public/uploads

EXPOSE 80