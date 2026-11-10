# Laravel 10 backend. vendor/ was installed with PHP 8.5 and requires PHP >= 8.4.
FROM php:8.4-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo_pgsql pgsql pdo_mysql zip intl \
    && rm -rf /var/lib/apt/lists/*

# Serve public/ and allow the .htaccess rewrites.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite

# Run Apache as the host user so it can write to the mounted storage/ folder.
ARG UID=1000
ARG GID=1000
RUN groupmod -o -g ${GID} www-data && usermod -o -u ${UID} -g ${GID} www-data

WORKDIR /var/www/html
