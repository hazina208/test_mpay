# Use official PHP Apache image
FROM php:8.2-apache

# Install system dependencies + Composer
RUN apt-get update && apt-get install -y \
    git unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable PHP extensions (you already had these + add gd for QR codes)
RUN docker-php-ext-install mysqli pdo pdo_mysql gd

# Copy composer files first (for better caching)
COPY composer.json composer.lock ./

# Install dependencies (this will download endroid/qr-code automatically)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of your application
COPY . /var/www/html/

# Set working directory and permissions for qr_images folder
WORKDIR /var/www/html/
# Create QR image directories and set proper permissions for Apache (www-data)
RUN mkdir -p qr_images paybill_qr_images \
    && chown -R www-data:www-data qr_images paybill_qr_images \
    && chmod -R 755 qr_images paybill_qr_images

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite
