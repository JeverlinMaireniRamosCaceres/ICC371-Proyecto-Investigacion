FROM php:8.5.5-apache

# instalar las dependencias que se necesitan
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        zip

# habilitar mod_rewrite
RUN a2enmod rewrite

# instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# directorio del proyecto
WORKDIR /var/www/html

# copiar php.ini personalizado
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# caonfiguracion de Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

EXPOSE 80