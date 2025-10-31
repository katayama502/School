FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
