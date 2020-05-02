FROM php:7.3.15-apache-stretch

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update \
&& apt-get install -y git gnupg unzip nodejs \
libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
&& docker-php-ext-install pdo_mysql mysqli mbstring \
&& docker-php-ext-install -j$(nproc) iconv \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install -j$(nproc) gd \
&& apt-get clean && rm -rf /var/lib/apt/lists/* \
&& a2enmod rewrite

COPY ./sites-enabled/000-default.conf /etc/apache2/sites-enabled/