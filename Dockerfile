# Dockerfile pour AppDAF (PHP)
FROM php:8.2-fpm

# Installe nginx, supervisor et extensions nécessaires
RUN apt-get update && \
    apt-get install -y nginx supervisor libpq-dev unzip git && \
    docker-php-ext-install pdo pdo_pgsql

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définit le répertoire de travail
WORKDIR /var/www/html

# Copie les fichiers du projet
COPY . .

# Vérifie si les fichiers de configuration existent avant de les copier
RUN if [ -f "nginx.conf" ]; then \
    cp nginx.conf /etc/nginx/sites-available/default; \
    else echo "nginx.conf n'existe pas, création d'une configuration par défaut"; \
    echo 'server { \
        listen 80; \
        root /var/www/html/public; \
        index index.php; \
        server_name _; \
        location / { \
            try_files $uri $uri/ /index.php$is_args$args; \
        } \
        location ~ \.php$ { \
            include snippets/fastcgi-php.conf; \
            fastcgi_pass 127.0.0.1:9000; \
        } \
    }' > /etc/nginx/sites-available/default; \
    fi

# Vérifie si supervisord.conf existe avant de le copier
RUN if [ -f "supervisord.conf" ]; then \
    cp supervisord.conf /etc/supervisor/conf.d/supervisord.conf; \
    else echo "supervisord.conf n'existe pas, création d'une configuration par défaut"; \
    echo '[supervisord] \
    nodaemon=true \
    [program:nginx] \
    command=nginx -g "daemon off;" \
    [program:php-fpm] \
    command=php-fpm' > /etc/supervisor/conf.d/supervisord.conf; \
    fi

# Configure Nginx
RUN rm -f /etc/nginx/sites-enabled/default && \
    ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Définit les permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Crée le dossier uploads s'il n'existe pas
RUN mkdir -p /var/www/html/public/uploads && \
    chmod -R 777 /var/www/html/public/uploads

# Installe les dépendances PHP via Composer
RUN composer install --no-dev --optimize-autoloader || \
    (echo "Erreur lors de l'installation des dépendances Composer, poursuite du build...")

# Expose le port 80
EXPOSE 80

# Démarre les services via supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]