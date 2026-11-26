# php:8.4-apache tracks the latest 8.4.x patch release; rebuild the image
# (Dev Containers: Rebuild Container) to pick up new PHP security fixes.
FROM php:8.4-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get update \
    && apt-get install -y git curl \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm i -g jshint \
    && rm -rf /var/lib/apt/lists/*
