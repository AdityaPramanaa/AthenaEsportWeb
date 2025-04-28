# Gunakan image PHP dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy semua file project ke dalam container
COPY . /var/www/html

# Set permission storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Enable mod_rewrite Apache
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80 