FROM php:7.2-fpm

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
    curl \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql

# Install the PHP gd library
RUN docker-php-ext-install gd && \
    docker-php-ext-configure gd \
    --with-jpeg-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

#Install PHP zip library
RUN docker-php-ext-install zip

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    supervisor

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer
