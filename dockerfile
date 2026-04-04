# Use official PHP Apache image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql gd

# Copy composer files
COPY composer.json composer.lock ./


# Copy the rest of the application
COPY . /var/www/html/

WORKDIR /var/www/html/

# Run composer at container startup instead
CMD composer install --no-dev --optimize-autoloader --no-scripts --no-interaction && apache2-foreground

# Create QR image directories
RUN mkdir -p qr_images paybill_qr_images \
    && chown -R www-data:www-data qr_images paybill_qr_images \
    && chmod -R 755 qr_images paybill_qr_images

# Enable Apache mod_rewrite
RUN a2enmod rewrite
