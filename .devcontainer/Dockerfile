FROM php:7.4-apache
RUN /usr/local/bin/docker-php-ext-install mysqli pdo pdo_mysql \
    && apt update \
    && apt install -y git;