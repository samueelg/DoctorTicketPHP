FROM php:8.4-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

# Extensões PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    pcntl \
    gd

RUN pecl install redis && docker-php-ext-enable redis

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia arquivos
COPY . .

# Instala dependências Laravel
RUN composer install

# Permissões
RUN chmod -R 775 storage bootstrap/cache

# Script de inicialização
CMD ["php-fpm"]