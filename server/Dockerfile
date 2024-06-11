# Utiliser une image de base PHP 8.2
FROM php:8.2-fpm

# Minimiser les couches en combinant les commandes RUN
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \  
    && rm -rf /var/lib/apt/lists/*  # Réduire la taille de l'image en nettoyant après l'installation

# Installer Composer de manière plus sécurisée
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www/server

# Copier le code source de l'API dans le conteneur
COPY . /var/www/server

ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer les dépendances avec Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev


# Modifier les permissions pour permettre à Laravel de gérer les fichiers de cache et de logs
RUN chown -R www-data:www-data /var/www/server/storage /var/www/server/bootstrap/cache

# Pour le développement, utiliser le serveur intégré PHP. Pour la production, utiliser un serveur web approprié.
CMD php -S 0.0.0.0:8000 -t public
