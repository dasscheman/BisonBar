FROM php:8.3-apache AS apache

COPY composer.lock composer.json /var/www/
# set workdir
WORKDIR /var/www

# upgrades!
RUN apt-get update
RUN apt-get -y dist-upgrade
RUN apt-get install -y zip

RUN apt-get install -y sudo nano
RUN apt-get update
RUN apt-get -y dist-upgrade
RUN apt-get install -y dos2unix

RUN apt-get install -y git
RUN apt-get install -y zip unzip libzip-dev
RUN apt-get install -y libxml2-dev
RUN apt-get install -y wget
RUN apt-get install -y iputils-ping
RUN apt-get install -y locales locales-all
RUN apt-get install -y libpng-dev

# install additional PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli soap gd

RUN apt-get clean -y

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
COPY ./docker/certificates/docker.dev.crt /usr/local/share/ca-certificates
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
