FROM php:8.2-fpm

# Встановлення залежностей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev

# Очищення кешу
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Встановлення розширень PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Встановлення Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Створення користувача
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Копіювання додатку
COPY . /var/www/html
COPY --chown=www:www . /var/www/html

# Зміна користувача
USER www

# Робоча директорія
WORKDIR /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
