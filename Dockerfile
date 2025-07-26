FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers vers le répertoire d'Apache
COPY . /var/www/html/

# Activer mod_rewrite (si tu utilises Laravel ou du routing)
RUN a2enmod rewrite
