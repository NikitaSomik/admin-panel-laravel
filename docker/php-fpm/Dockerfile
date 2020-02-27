########################
### Stage - "base"
########################
FROM php:7.4.2-fpm

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -y \
    apt-transport-https \
    ca-certificates \
    openssh-client \
    curl \
    dos2unix \
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
    bcmath \
    sockets

# configure packages
RUN docker-php-ext-configure intl

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
    APP_NAME=Laravel \
    APP_ENV=local \
    APP_DEBUG=true \
    APP_URL=http://admin-panel.local \

    LOG_CHANNEL=stack \

    DB_CONNECTION=mysql \
    DB_HOST=mysql \
    DB_PORT=3306 \
    DB_DATABASE=admin-panel \
    DB_USERNAME=admin \
    DB_PASSWORD=admin! \

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
    MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}" \

    COMPOSE_FILE=./docker/docker-compose.yml

# Many more ENV may be needed here, and updated in docker-php-entrypoint file

COPY ./wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Boot.sh
COPY ./boot.sh /usr/local/bin/php_boot.sh
RUN chmod +x /usr/local/bin/php_boot.sh

CMD /usr/local/bin/wait-for-it.sh mysql:3306 -- /usr/local/bin/php_boot.sh
