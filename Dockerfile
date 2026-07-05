FROM php:8.3-apache

# Instal dependensi sistem dan library untuk ekstensi PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev

# Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instal ekstensi PHP (GD penting untuk dompdf, pdo_mysql untuk database)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Aktifkan mod_rewrite Apache (wajib untuk routing Laravel)
RUN a2enmod rewrite

# Instal Composer dari image resminya
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instal NodeJS (untuk membuild aset Tailwind & AlpineJS via Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set direktori kerja di dalam container
WORKDIR /var/www/html

# Salin seluruh kode aplikasi (kecuali yang ada di .dockerignore)
COPY . /var/www/html

# Salin konfigurasi VirtualHost Apache
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instal dependensi PHP (tanpa package dev untuk production)
RUN composer install --optimize-autoloader --no-dev

# Instal dependensi NodeJS dan build aset production
RUN npm install
RUN npm run build

# Atur perizinan folder yang wajib bisa ditulis oleh Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Buka port 80 (internal container)
EXPOSE 80

# Jalankan Apache di background
CMD ["apache2-foreground"]
