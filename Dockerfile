FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80
