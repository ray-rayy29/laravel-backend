FROM php:8.2-fpm-alpine

# Install extensions & system utilities + gettext untuk envsubst
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip git gettext \
    && docker-php-ext-install pdo_mysql bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Setup Nginx configuration
COPY ./nginx.conf /etc/nginx/nginx.conf

# PERBAIKAN RADIKAL: Berikan hak akses penuh ke Nginx (www-data) untuk SELURUH folder /var/www 👇
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Jalankan envsubst untuk menyuntikkan $PORT, lalu jalankan php-fpm dan nginx
CMD sh -c "envsubst '\$PORT' < /etc/nginx/nginx.conf > /etc/nginx/nginx.conf.tmp && mv /etc/nginx/nginx.conf.tmp /etc/nginx/nginx.conf && php-fpm -D && nginx -g 'daemon off;'"
