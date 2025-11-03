FROM php:8.2-cli

# Cài extension cần thiết
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-interaction --optimize-autoloader

# Tạo sẵn thư mục và quyền ghi
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
 && chmod -R 777 storage bootstrap/cache

EXPOSE 8000

# 🔹 CMD đảm bảo Laravel khởi động sạch mỗi lần container chạy
CMD ["sh", "-c", "\
    mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache && \
    if [ ! -f .env ]; then cp .env.example .env && php artisan key:generate; fi && \
    php artisan config:clear && php artisan cache:clear && php artisan view:clear && \
    php artisan serve --host=0.0.0.0 --port=8000 \
"]
