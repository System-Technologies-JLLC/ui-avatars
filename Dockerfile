#FROM kstaken/apache2
#FROM ulsmith/alpine-apache-php7
#LABEL name "my-docker-deployment"

# RUN apt-get update && apt-get install -y php7.2 curl git zip libapache2-mod-php7.2 php7.2-mysql php7.2-cli && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install system dependencies
# RUN apt-get update && apt-get install -y \
#    git \
#    curl \
#   libpng-dev \
#    libonig-dev \
#    libxml2-dev \
#    zip \
#    unzip 
 #   libapache2-mod-php7.4 \
 #   php7.4-mysql \
 #   php7.4-cli

# Clear cache
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
#RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

FROM php:7.4-fpm

#FROM ubuntu:latest

## for apt to be noninteractive
#ENV DEBIAN_FRONTEND noninteractive
#ENV DEBCONF_NONINTERACTIVE_SEEN true

# Install system dependencies
RUN apt-get update && apt-get install -y \
    php7.4 \
    curl \
    git \
    zip \
  #  libapache2-mod-php7.4 \
  #  php7.4-mysql \
  #  php7.4-cli \
    nginx
    
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#COPY site.conf /etc/nginx/conf.d/default.conf

COPY vendor /var/www/vendor
COPY Utils /var/www/Utils
COPY api /var/www/api
COPY assets /var/www/assets
COPY index.html /var/www/index.html

EXPOSE 80
EXPOSE 443

# CMD ["/usr/sbin/apache2", "-D", "FOREGROUND"]
