FROM php:8.1-fpm

# Add global binary directory to PATH and make sure to re-export it
ENV PATH=/composer/vendor/bin:$PATH

# Allow Composer to be run as root
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_VERSION=2.7.7
ENV COMPOSER_HOME=/composer

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libxml2-dev \
    openssl \
    libpng-dev \
    libssl-dev \
    curl \
    zip \
    unzip \
    supervisor \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    --no-install-recommends \
    && rm -r /var/lib/apt/lists/*

# Install pcntl
RUN docker-php-ext-install \
    pcntl \
    exif \
    bcmath \
    intl \
    pdo pdo_pgsql pgsql sockets \
    # Install gd
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd
    

# Setup the Composer installer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
  && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} && rm -rf /tmp/composer-setup.php

RUN apt-get update -y

# Install bz2 library git
RUN apt-get update \
    && apt-get install -y git libbz2-dev \
    && docker-php-ext-install bz2

# Install opcache
RUN docker-php-ext-install opcache &&\
    docker-php-ext-enable opcache

WORKDIR /var/www

RUN ["ln", "-s", "/var/www/src/vendor/bin/phpunit", "/usr/local/bin/phpunit"]

ENV FPM_PM_MAX_CHILDREN=20
ENV FPM_PM_START_SERVERS=3
ENV FPM_PM_MIN_SPARE_SERVERS=3
ENV FPM_PM_MAX_SPARE_SERVERS=8
ENV FPM_PM_MAX_REQUESTS=500
ENV PHP_OPCACHE=0

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

CMD ["php-fpm"]

# Add local web-user
ENV WEB_USER_ID=1000
ENV WEB_USER_NAME="web"
ENV WEB_GROUP_ID=1000
ENV WEB_GROUP_NAME="web"
RUN echo "Building for web user: id=${WEB_USER_ID} name=${WEB_USER_NAME} group=${WEB_GROUP_NAME}"
RUN groupadd -g ${WEB_GROUP_ID} ${WEB_GROUP_NAME}|| echo "Group exists"
RUN useradd -m -u ${WEB_USER_ID} ${WEB_USER_NAME} -g ${WEB_GROUP_NAME} || echo "Users exists"
RUN sed -i -- "s/user = www-data/user = ${WEB_USER_NAME}/g" /usr/local/etc/php-fpm.d/www.conf
USER ${WEB_USER_ID}
