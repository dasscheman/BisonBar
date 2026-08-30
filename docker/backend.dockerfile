FROM php:8.4-apache AS apache

COPY composer.json /var/www/
# set workdir
WORKDIR /var/www

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        sudo \
        nano \
        dos2unix \
        git \
        zip \
        unzip \
        libzip-dev \
        libxml2-dev \
        wget \
        iputils-ping \
        locales \
        libpng-dev \
        mariadb-client \
    && sed -i '/en_US.UTF-8/s/^# //g; /nl_NL.UTF-8/s/^# //g' /etc/locale.gen \
    && locale-gen \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

# install additional PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli soap gd zip

# install additional webserver packages
RUN a2enmod ssl
RUN a2enmod rewrite
RUN a2enmod headers

# set corrent TimeZone
ENV TZ=Europe/Amsterdam
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# copy httpd files
COPY ./docker/httpd.conf /etc/apache2/sites-enabled/000-default.conf

# copy webapp files
COPY .. /var/www

# install composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
# run composer

#RUN composer install
## TODO eigenlijk wil je een image zonder  dev packages.
##RUN composer install --no-dev --no-scripts

# install self signed certifcates to thrust other local dev environments
COPY ./docker/certificates/apache/docker.dev.crt /usr/local/share/ca-certificates
RUN cd /usr/local/share/ca-certificates && update-ca-certificates

COPY ./docker/docker.env /var/www/.env

# entrypoint
COPY ./docker/backend-entrypoint.sh /entrypoint.sh
RUN chmod ugo+x /entrypoint.sh

RUN chmod 775 -R /var/www/storage
RUN touch /var/log/heartbeat.log
RUN touch /var/log/runner.log
RUN chown www-data /var/log/heartbeat.log
RUN chown www-data /var/log/runner.log


ENTRYPOINT /entrypoint.sh
