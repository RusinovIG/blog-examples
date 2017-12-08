FROM php:7
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_pgsql mbstring
RUN pecl install xdebug-2.5.0 \
	&& docker-php-ext-enable xdebug
RUN echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_port=9000 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_autostart=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_connect_back=0 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.idekey=PHP_STORM >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_host=172.18.0.1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ADD . /test_project
WORKDIR /test_project
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181