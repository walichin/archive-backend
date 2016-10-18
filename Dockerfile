FROM php:5.6.26-apache

COPY docker-config/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN ln -s /etc/apache2/mods-available/headers.load /etc/apache2/mods-enabled/headers.load

RUN docker-php-ext-configure mysql --with-mysql=mysqlnd && \
    docker-php-ext-configure mysqli --with-mysqli=mysqlnd && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install mysql 

RUN mkdir -p /var/www/html/photo-adm

COPY photo-adm/ /var/www/html/photo-adm

RUN mkdir /home/logs




