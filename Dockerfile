FROM php:7.4-fpm

MAINTAINER i.kupriyanov@petrosoftinc.com

WORKDIR /var/www/service

ADD . /var/www/service


RUN apt update && apt install --assume-yes --quiet htop mc zip iputils-ping telnet && \
    docker-php-ext-install pcntl sockets && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


EXPOSE 80
EXPOSE 9000

CMD ["php-fpm"]
#CMD ["php"]
