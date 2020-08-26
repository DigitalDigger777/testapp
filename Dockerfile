FROM php:7.4-apache

# PSR for phalcon 4.x
ARG PSR_VERSION=0.6.1

ARG PHALCON_VERSION=4.0.3
ARG PHALCON_EXT_PATH=php7/64bits
#ARG DEBIAN_FRONTEND=noninteractive


RUN set -xe && \
        # Compile PSR
        curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
        cd ${PWD}/php-psr-${PSR_VERSION} && \
        phpize && \
        ./configure && \
        make && \
        make test && \
        make install

RUN set -xe && \
        # Compile Phalcon
        curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
        cd ${PWD}/cphalcon-${PHALCON_VERSION}/build/ && \
        ./install


# Install packages
RUN apt autoremove && apt-get update && \
        apt-get install -y sensible-utils && \
        apt-get install -y libpng-dev && \
        apt-get install nano && \
        apt-get install -y libzip-dev && \
        apt-get install -y libzip4

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo
RUN docker-php-ext-install mysqli

# Enable mod rewrite
RUN a2enmod rewrite
