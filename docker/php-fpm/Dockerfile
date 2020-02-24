########################
### Stage - "base"
########################
FROM php:7.4.2-fpm as dev

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -y \
    apt-transport-https \
    ca-certificates \
    openssh-client \
    curl \
    dos2unix \
    git \
    gnupg2 \
    dirmngr \
    g++ \
    jq \
    libedit-dev \
    libfcgi0ldbl \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpq-dev \
    supervisor \
    unzip \
    libssl-dev \
    zip \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    json \
    readline \
    gd \
    intl \
    pdo \
    pdo_pgsql \
    pgsql \
    bcmath \
    sockets

# install mongodb ext
#RUN pecl install mongodb \
#    && docker-php-ext-enable mongodb

# configure packages
#RUN docker-php-ext-configure intl
#RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

ENV TZ=Europe/Oslo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/back

# Composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 1.9.1

RUN set -eux; \
  curl --silent --fail --location --retry 3 --output /tmp/installer.php --url https://raw.githubusercontent.com/composer/getcomposer.org/cb19f2aa3aeaa2006c0cd69a7ef011eb31463067/web/installer; \
  php -r " \
    \$signature = '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5'; \
    \$hash = hash('sha384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
      unlink('/tmp/installer.php'); \
      echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
      exit(1); \
    }"; \
  php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION}; \
  composer --ansi --version --no-interaction; \
  rm -f /tmp/installer.php; \
  find /tmp -type d -exec chmod -v 1777 {} +

# Laravel App Config
# setup app config environment at runtime
# gets put into ./.env at startup
ENV TZ=Europe/Kiev \
    APP_NAME=Temabok \
    APP_ENV=local \
    APP_DEBUG=true \
    APP_URL=http://localhost \
    APP_TIMEZONE=Europe/Kiev \

    LOG_CHANNEL=stack \

    DB_CONNECTION=mysql \
    DB_HOST=mysql \
    DB_PORT=3306 \

#    DB_CONNECTION=pgsql \
#    DB_HOST_MANAGEMENT=postgres \
#    DB_PORT_MANAGEMENT=5432 \
#
#    DB_CONNECTION_DRAFT=mongodb \
#    DB_HOST_DRAFT=mongo \
#    DB_PORT_DRAFT=27017 \

    FILESYSTEM_DRIVER=public_uploads \

    BROADCAST_DRIVER=log \
    CACHE_DRIVER=file \
    QUEUE_CONNECTION=sync \
    SESSION_DRIVER=file \
    SESSION_LIFETIME=120 \

    REDIS_HOST=127.0.0.1 \
    REDIS_PASSWORD=null \
    REDIS_PORT=6379 \

    MAIL_DRIVER=smtp \
    MAIL_HOST=smtp.mailtrap.io \
    MAIL_PORT=2525 \
    MAIL_USERNAME=null \
    MAIL_PASSWORD=null \
    MAIL_ENCRYPTION=null \

    MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}" \
    MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
# Many more ENV may be needed here, and updated in docker-php-entrypoint file

#COPY devops/php/wait-for-it.sh /usr/local/bin/wait-for-it.sh
#RUN chmod +x /usr/local/bin/wait-for-it.sh

# Boot.sh
COPY docker/boot.sh /usr/local/bin/php_boot.sh
RUN chmod +x /usr/local/bin/php_boot.sh

#CMD /usr/local/bin/wait-for-it.sh postgres:5432 -- /usr/local/bin/wait-for-it.sh mongo:27017 -- /usr/local/bin/php_boot.sh



########################
### Stage - "development"
########################
FROM base as test

RUN apt-get update && apt-get install -y wget git unzip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini



########################
### Stage - "test"
########################
FROM base as test

#WORKDIR /var/www/back
#
#COPY devops/php/boot.test.sh /usr/local/bin/php_boot.sh
#RUN chmod +x /usr/local/bin/php_boot.sh
#
#COPY . .
#
#RUN chown -R :www-data storage bootstrap/cache
#RUN chmod -R g+w storage bootstrap/cache
#
#RUN composer install --no-scripts --no-autoloader --ansi --no-interaction -d /var/www/back
#RUN composer dump-autoload -d /var/www/back
#
#CMD /usr/local/bin/wait-for-it.sh postgres:5432 -- /usr/local/bin/wait-for-it.sh mongo:27017 -- /usr/local/bin/php_boot.sh



########################
### Stage - "production"
########################
#FROM base as prod
#
#COPY --chown=www-data:www-data .. /var/www/back
#RUN /usr/local/bin/composer.phar dump-autoload -o
