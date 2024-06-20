FROM php:8.2-fpm


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


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www/server


COPY . /var/www/server

ENV COMPOSER_ALLOW_SUPERUSER=1


RUN composer install --no-interaction --optimize-autoloader --no-dev



RUN chown -R www-data:www-data /var/www/server/storage /var/www/server/bootstrap/cache


CMD php -S 0.0.0.0:8000 -t public
