FROM php:8.1-fpm

LABEL maintainer="Lucas Maia <lucas.codemax@gmail.com>"
WORKDIR /var/www/html

RUN docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    opcache \
    pdo_mysql \
    sockets

RUN pecl install redis && docker-php-ext-enable redis \
    && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/* /var/tmp/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . .
RUN composer install
COPY . .

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html/public"]
