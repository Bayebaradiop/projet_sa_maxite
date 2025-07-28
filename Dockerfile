FROM php:8.2-apache

# Installe les extensions nécessaires
RUN apt-get update && apt-get install -y libpq-dev unzip curl \
    && docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code source
WORKDIR /var/www/html
COPY . /var/www/html

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Droits
RUN chown -R www-data:www-data /var/www/html

# Créer le dossier uploads si besoin
RUN mkdir -p /var/www/html/public/uploads && chmod -R 777 /var/www/html/public/uploads

EXPOSE 80

# Apache démarre automatiquement