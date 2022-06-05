FROM ubuntu:22.04

# Set working directory
WORKDIR /var/www

ARG WWWUSER
ARG WWWGROUP

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Update repositories
RUN apt-get update && apt-get install -y curl ca-certificates zip cron nginx unzip git supervisor libcap2-bin

# Install PHP and extenstions
RUN apt-get install -y php8.1-fpm \
      php8.1-pgsql php8.1-curl \
      php8.1-mbstring php8.1-xml \
      php8.1-zip php8.1-bcmath \
      php8.1-intl php8.1-readline \
      php8.1-msgpack php8.1-igbinary \
      php8.1-ldap php8.1-xdebug

# Install composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Istall Node.js
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Install Databases
RUN apt-get update \
    && apt-get install -y postgresql-client

# Make apt-get clean
RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy custom configurations
COPY ./etc/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./etc/php/config-override.ini /etc/php/8.1/fpm/conf.d/config-override.ini
COPY ./etc/nginx/app.conf /etc/nginx/sites-enabled/default
COPY ./etc/crontab/crontab /etc/cron.d/crontab

# Set user and group
RUN groupadd --force -g $WWWGROUP www-data
RUN usermod -u ${WWWUSER} www-data && groupmod -g ${WWWGROUP} www-data

ENTRYPOINT ["sh", "./docker/app/entrypoint.sh"]
