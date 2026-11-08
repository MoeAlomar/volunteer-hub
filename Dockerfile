FROM php:8.5-apache

RUN apt-get update \
 && apt-get install -y --no-install-recommends libpq-dev libzip-dev unzip git \
 && docker-php-ext-install pdo_pgsql zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

# Serve Laravel's /public folder, and listen on the port Cloud Run gives us ($PORT).
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV PORT=8080
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && sed -ri -e 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
 && sed -ri -e 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf

RUN printf '<IfModule mpm_prefork_module>\n  StartServers 2\n  MinSpareServers 2\n  MaxSpareServers 4\n  MaxRequestWorkers 10\n</IfModule>\n' > /etc/apache2/conf-available/limits.conf && a2enconf limits

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction \
 && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache

CMD ["apache2-foreground"]
