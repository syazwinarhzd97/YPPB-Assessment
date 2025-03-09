# Use an official PHP image with PHP-FPM
FROM php:8.1-fpm

# Install required dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Set the working directory
WORKDIR /var/www

# Copy the Laravel application into the container
COPY . .

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run Composer to install Laravel dependencies
RUN composer install

# Set permissions for the Laravel application
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 to the outside
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
