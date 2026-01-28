# # Gunakan image PHP resmi dengan Apache
# FROM php:8.2-apache

# # Instal dependensi sistem yang diperlukan Laravel
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     git \
#     libzip-dev \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd pdo pdo_mysql zip

# # Aktifkan mod_rewrite untuk Apache (Penting untuk Laravel)
# RUN a2enmod rewrite

# # Instal Composer secara resmi
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Set working directory
# WORKDIR /var/www/html

# # Copy project ke dalam container
# COPY . .

# # Set izin folder agar Laravel bisa menulis log/cache
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Update konfigurasi Apache agar mengarah ke folder /public
# ENV APACHE_DOCUMENT_ROOT /var/www/html/public
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# # Instal dependensi PHP (Composer)
# RUN composer install --no-dev --optimize-autoloader

# # Expose port 80
# EXPOSE 80

# CMD ["apache2-foreground"]


FROM php:8.2-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Ambil Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

COPY . .

# Install tanpa script agar tidak error saat build
RUN composer install --no-scripts --no-autoloader

# Beri izin folder
RUN chown -R www-data:www-data /var/www