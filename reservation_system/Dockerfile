# Use PHP 8.0 with Apache
FROM php:8.0-apache

# Copy project files to the Apache web root
COPY . /var/www/html/

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite

# Optional: set correct file permissions (if needed)
RUN chown -R www-data:www-data /var/www/html
