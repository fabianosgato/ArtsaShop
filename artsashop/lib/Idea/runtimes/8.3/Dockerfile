FROM php:8.3-apache

RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    --no-install-recommends \
    && docker-php-ext-enable opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd \
    && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/*

# Update apache conf to point to application public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Update uploads config
RUN echo "file_uploads = On\n" \
         "memory_limit = 4096M\n" \
         "upload_max_filesize = 512M\n" \
         "post_max_size = 512M\n" \
         "max_execution_time = 1200\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

# Enable headers module
RUN a2enmod rewrite headers ssl

RUN echo "INCIO: PERMISSOES DOS DIRETORIOS"
RUN mkdir -p /var/www/html/storage
RUN chmod -R 777 /var/www/html/storage
RUN mkdir -p /var/www/html/bootstrap/cache
RUN chmod -R 777 /var/www/html/bootstrap/cache
RUN mkdir -p /var/www/html/storage/logs
RUN chmod -R 777 /var/www/html/storage/logs
RUN echo "FIM: PERMISSOES DOS DIRETORIOS"

EXPOSE 8000

