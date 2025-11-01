# Gunakan base image PHP dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-cli

# Install dependency yang diperlukan untuk intl dan zip
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install intl zip pdo_mysql

# Copy semua file project ke dalam container
COPY . /var/www

WORKDIR /var/www

# Install composer (kalau belum ada di base image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Jalankan composer install
RUN composer install --optimize-autoloader --no-interaction --no-scripts

# Jalankan artisan command (opsional)
RUN php artisan config:cache && php artisan route:cache

RUN chmod -R 777 storage bootstrap/cache

# Default command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]


