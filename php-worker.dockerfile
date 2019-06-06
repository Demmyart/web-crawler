FROM php:7.2-cli-stretch
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libpq-dev \
        libxml2-dev \
    && docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) xml \
    && docker-php-ext-install -j$(nproc) mbstring
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip
RUN apt-get install -y \
        librabbitmq-dev \
  && pecl install amqp && docker-php-ext-enable amqp
WORKDIR /var/www/ccf-project/
COPY ./backend /var/www/ccf-project/
COPY wait-for-services.sh /var/www/wait-for-services.sh
CMD ["/bin/bash", "/var/www/wait-for-services.sh"]