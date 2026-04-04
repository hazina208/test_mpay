# Use official PHP Apache image
FROM php:8.2-apache

# Install system dependencies + Composer
RUN apt-get update && apt-get install -y \
    git unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure and install PHP extensions
# mysqli, pdo, pdo_mysql are simple and don't need extra libs
# gd needs configuration for jpeg/png/freetype support (required for QR codes)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql gd

# Copy composer files first (for better caching)
COPY composer.json composer.lock ./

# Install dependencies (this will download endroid/qr-code automatically)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of your application
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Create QR image directories and set proper permissions for Apache (www-data)
RUN mkdir -p qr_images paybill_qr_images \
    && chown -R www-data:www-data qr_images paybill_qr_images \
    && chmod -R 755 qr_images paybill_qr_images

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite
