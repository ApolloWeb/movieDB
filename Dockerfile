FROM php:8.1-apache

ENV APACHE_DOCUMENT_ROOT /var/www/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite && a2enmod headers

RUN apt-get update && apt-get install wget git zip libjpeg-dev libwebp-dev \
libpng-dev libjpeg62-turbo-dev libjpeg-turbo-progs libjpeg62-turbo cron nano default-mysql-client gnupg \
zlib1g-dev libicu-dev g++ -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -

RUN apt-get install -y nodejs

RUN docker-php-ext-install pdo_mysql mysqli \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip

RUN \
    apt-get update && \
    apt-get install libldap2-dev -y && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

RUN echo "upload_max_filesize = 64M\npost_max_size = 128M\nmax_input_vars = 5000" > \
    /usr/local/etc/php/conf.d/project.ini

RUN rm /var/www -rf

RUN chown -R www-data:www-data /var/www

COPY --chown=www-data:www-data . /var/www/

USER www-data

RUN npm install

WORKDIR /var/www/

RUN composer install --no-interaction --no-dev \
    && composer dump-autoload -o

RUN npm run build

WORKDIR /var/www/

USER root

EXPOSE 80
