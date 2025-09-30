# Use official PHP Apache image
FROM php:8.2-apache

# Enable extensions (mysqli/pdo_mysql for MySQL support)
RUN docker-php-ext-install mysqli pdo pdo_mysql


# Copy your PHP code into container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/



