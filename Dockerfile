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

# Permissões (vale para o caso de produção, onde os arquivos vêm da imagem)
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Entrypoint: ajusta a posse de storage/cache em runtime (cobre dev com bind mount)
COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

# Script de inicialização
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]