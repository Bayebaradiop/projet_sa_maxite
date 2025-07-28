# Dockerfile pour projet PHP avec Apache (sans Nginx ni Supervisor)
FROM php:8.2-apache

# Installe les dépendances système nécessaires AVANT d'installer l'extension
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Active mod_rewrite pour Apache
RUN a2enmod rewrite

# Copie le code source dans le conteneur
COPY . /var/www/html

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html

# Configure le VirtualHost pour pointer sur public/
WORKDIR /var/www/html/public

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader || true

# Crée le dossier uploads s'il n'existe pas
RUN mkdir -p /var/www/html/public/uploads && \
    chmod -R 777 /var/www/html/public/uploads

# Expose le port 80
EXPOSE 80

# Lance Apache en mode premier plan
CMD ["apache2-foreground"]