FROM alpine:3.21

LABEL maintainer="Gabriel Morishita"

ARG WWWGROUP
ARG NODE_VERSION=22
ARG MYSQL_CLIENT="mariadb-client"
ARG POSTGRES_VERSION=17

WORKDIR /var/www/html

ENV TZ=UTC
ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
ENV SUPERVISOR_PHP_USER="sail"

# Install base packages and configure system
RUN apk add --no-cache --update \
    tzdata \
    curl \
    bash \
    git \
    supervisor \
    sudo \
    gnupg \
    libcap \
    libpng-dev \
    librsvg \
    python3 \
    ffmpeg \
    nano \
    dcron \
    shadow \
    && cp /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone \
    && rm -rf /var/cache/apk/*

# Install PHP and extensions
RUN apk add --no-cache \
    php84 \
    php84-phar \
    php84-common \
    php84-dom \
    php84-pcntl \
    php84-cli \
    php84-tokenizer \
    php84-fileinfo \
    php84-fpm \
    php84-pdo \
    php84-pdo_mysql \
    php84-pdo_pgsql \
    php84-gd \
    php84-curl \
    php84-mbstring \
    php84-xml \
    php84-xmlwriter \
    php84-zip \
    php84-bcmath \
    php84-soap \
    php84-intl \
    php84-simplexml \
    php84-ldap \
    php84-opcache \
    php84-sodium \
    php84-pecl-redis \
    php84-pecl-memcached \
    php84-pecl-swoole \
    php84-pecl-xdebug \
    php84-pecl-imagick \
    && ln -s /usr/bin/php84 /usr/bin/php

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and package managers
RUN apk add --no-cache nodejs npm \
    && npm install -g npm \
    && npm install -g pnpm \
    && npm install -g bun

# Install database clients
RUN apk add --no-cache \
    ${MYSQL_CLIENT} \
    postgresql${POSTGRES_VERSION}-client \
    sqlite

# Configure system
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php84

# Create user/group
RUN if [ $(getent group $WWWGROUP) ]; then \
      groupmod -g $WWWGROUP sail; \
    else \
      addgroup -g $WWWGROUP sail; \
    fi \
    && adduser -D -s /bin/bash -G sail -u 1337 sail

RUN mkdir -p /var/log/supervisor \
    && chmod 755 /var/log/supervisor \
    && touch /var/log/supervisor/supervisord.log

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php84/conf.d/99-sail.ini

RUN chmod +x /usr/local/bin/start-container

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
