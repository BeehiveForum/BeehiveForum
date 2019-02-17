FROM php:7-fpm-alpine

RUN apk update && apk upgrade

RUN apk add freetype-dev gettext-dev icu-dev libjpeg-turbo-dev libpng-dev

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install gd
RUN docker-php-ext-install gettext
RUN docker-php-ext-install intl

RUN docker-php-ext-enable mysqli
RUN docker-php-ext-enable gd
RUN docker-php-ext-enable gettext
RUN docker-php-ext-enable intl