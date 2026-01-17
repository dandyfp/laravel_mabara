FROM richarvey/php-apache-heroku:latest

# Copy seluruh isi project ke folder server
COPY . /var/www/app

# Set environment variabel untuk Laravel
ENV WEBROOT /var/www/app/public
ENV APP_ENV production

# Jalankan instalasi composer
RUN composer install --no-dev --optimize-autoloader

# Beri izin akses ke folder storage
RUN chmod -R 777 /var/www/app/storage /var/www/app/bootstrap/cache

EXPOSE 80