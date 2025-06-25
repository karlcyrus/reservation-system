# Use PHP 8.0 with Apache
FROM php:8.0-apache

# Install PDO and PostgreSQL extensions
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Enable Apache mod_rewrite (optional but good for routing)
RUN a2enmod rewrite

# Set the working directory (optional, but keeps it clean)
WORKDIR /var/www/html

# Copy all project files to Apache root
COPY . /var/www/html/
