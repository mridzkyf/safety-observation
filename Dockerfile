FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]

EXPOSE 9000

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

