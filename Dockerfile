FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

RUN composer install --optimize-autoloader --no-dev

EXPOSE 9000

CMD ["php-fpm"]
