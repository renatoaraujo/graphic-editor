FROM php:5.6-cli

COPY . /app

RUN apt-get update && \
    apt-get install zip libcurl3-dev zlib1g-dev libpng-dev libyaml-dev -y

RUN docker-php-ext-install ctype curl json zip gd

RUN pecl channel-update pecl.php.net && \
    pecl install yaml-1.3.1 && docker-php-ext-enable yaml

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

RUN chmod +x /usr/bin/composer

CMD php -S 0.0.0.0:80 /app/public/index.php
