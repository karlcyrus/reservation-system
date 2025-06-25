# Use PHP 8.0 with Apache
FROM php:8.0-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (optional)
RUN a2enmod rewrite

# Copy all project files to the container's web root
COPY . /var/www/html/
