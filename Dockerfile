FROM php:apache

RUN apt-get update && apt upgrade -y

ADD ./src /var/www/html

EXPOSE 80