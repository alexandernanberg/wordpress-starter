FROM php:7.1-apache

# Install the PHP extensions we need
RUN apt-get update \
  && apt-get install -y \
    bzip2 \
    git \
    subversion \
    libpng12-dev \
    libjpeg-dev \
    && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
  && docker-php-ext-install gd mysqli opcache zip

# Set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
  } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Apache configuration
ADD ./config/apache.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite expires

# Workdir
WORKDIR /var/www

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV ACF_PRO_KEY b3JkZXJfaWQ9NTYzODJ8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE1LTA1LTE5IDEzOjI2OjM4
ADD composer.json ./composer.json
ADD composer.lock ./composer.lock
RUN composer install --no-scripts --no-autoloader --no-dev

# Add files
ADD . ./

# Compoer optimize and post install scripts
RUN composer dump-autoload --optimize && \
	composer run-script post-install-cmd

# Set permissions
RUN chown -R www-data:www-data /var/www/public

# Start apache
CMD ["apache2-foreground"]
