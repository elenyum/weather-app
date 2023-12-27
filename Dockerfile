# Use PHP 8.2 FPM as base image
FROM php:8.2-fpm

# Update package lists
RUN apt-get update

# Install required extensions/libraries
RUN apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql # Additional extensions for Laravel

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel application files
COPY ./app /var/www/html

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Set folder permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 bootstrap/cache
RUN chmod -R 775 storage

# Expose port 9000
EXPOSE 9000

