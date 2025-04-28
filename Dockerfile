# Gunakan image PHP dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files terlebih dahulu
COPY composer.json composer.lock ./

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Copy semua file project ke dalam container
COPY . .

# Set permission storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Enable mod_rewrite Apache
RUN a2enmod rewrite

# Set composer memory limit
ENV COMPOSER_MEMORY_LIMIT=-1

# Allow composer to run as superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Set environment variables
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV PORT=80

# Configure Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose port yang ditentukan oleh Railway
EXPOSE ${PORT}

# Start Apache in foreground
CMD ["apache2-foreground"] 