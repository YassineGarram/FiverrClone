FROM php:8.0-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && apt-get upgrade -y && apt install -y default-mysql-client
