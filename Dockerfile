FROM php:8.2-fpm-alpine

# Install extensions & system utilities
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip git \
    && docker-php-ext-install pdo_mysql bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Setup Nginx configuration template
COPY ./nginx.conf /etc/nginx/nginx.conf.template

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["/bin/sh", "-c", "envsubst '$PORT' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf && php-fpm -D && nginx -g 'daemon off;'"]
