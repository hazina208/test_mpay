# Use official PHP Apache image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer (multi-stage for best practice)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure and install PHP extensions (GD is required by endroid/qr-code)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql gd

# Set working directory
WORKDIR /var/www/html/

# Copy composer files first (for better layer caching)
COPY composer.json composer.lock ./

# Install dependencies during BUILD time (recommended)
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction \
    && rm /usr/bin/composer   # Optional: remove composer after install

# Now copy the rest of the application
COPY . /var/www/html/

# Create QR directories with correct permissions
RUN mkdir -p qr_images paybill_qr_images \
    && chown -R www-data:www-data /var/www/html/qr_images /var/www/html/paybill_qr_images \
    && chmod -R 755 /var/www/html/qr_images /var/www/html/paybill_qr_images

# Enable Apache mod_rewrite (if you need clean URLs)
RUN a2enmod rewrite

# Apache runs as www-data by default in php:apache image
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]