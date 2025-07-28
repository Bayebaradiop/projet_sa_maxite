FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN a2enmod rewrite
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN echo "APP_NAME=${APP_NAME}" > .env && \
    echo "APP_ENV=${APP_ENV}" >> .env && \
    echo "APP_DEBUG=${APP_DEBUG}" >> .env && \
    echo "URL=${URL}" >> .env && \
    echo "DB_HOST=${DB_HOST}" >> .env && \
    echo "DB_PORT=${DB_PORT}" >> .env && \
    echo "DB_DATABASE=${DB_DATABASE}" >> .env && \
    echo "DB_USERNAME=${DB_USERNAME}" >> .env && \
    echo "DB_PASSWORD=${DB_PASSWORD}" >> .env && \
    echo "dsn=${dsn}" >> .env && \
    echo "TWILIO_SID=${TWILIO_SID}" >> .env && \
    echo "TWILIO_TOKEN=${TWILIO_TOKEN}" >> .env && \
    echo "TWILIO_FROM=${TWILIO_FROM}" >> .env && \
    echo "IMG_DIR=${IMG_DIR}" >> .env

RUN chown -R www-data:www-data /app
RUN chmod -R 755 /app

EXPOSE 80