# from https://www.drupal.org/requirements/php#drupalversions
FROM php:7.1-apache

RUN apt-get update \
&& apt-get install -y libpng12-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpq-dev \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install pdo pdo_mysql gd opcache

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version
RUN apt-get install git zip unzip -y

# Install Drupalconsole
#RUN curl https://drupalconsole.com/installer -L -o drupal.phar
#RUN mv drupal.phar /usr/local/bin/drupal && chmod +x /usr/local/bin/drupal

# Download console.
RUN curl https://drupalconsole.com/installer -L -o drupal.phar

# Install console.
RUN mv drupal.phar /usr/local/bin/drupal && \
    chmod +x /usr/local/bin/drupal && \
    drupal init --override

# Set the Drush version.
ENV DRUSH_VERSION 8.1.2
RUN curl -fsSL -o /usr/local/bin/drush "https://github.com/drush-ops/drush/releases/download/$DRUSH_VERSION/drush.phar" && \
  chmod +x /usr/local/bin/drush
RUN drush core-status
RUN apt-get update && apt-get install -y postgresql-client && apt-get install -y mysql-client

# Set rewrite module for apache
RUN a2enmod rewrite

# Set vhost
COPY ./.docker/apache-php/include/apache.conf /etc/apache2/sites-enabled/000-default.conf

# Set OPCACHE settings
RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=60'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

WORKDIR /var/www/html
#ADD . /var/www/html

RUN drupal settings:set checked "true"
