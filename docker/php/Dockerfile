FROM php:8.1.0RC6-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    cron \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install exif \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gd \
    && docker-php-source delete \
	&& docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
	&& docker-php-ext-install pdo pdo_pgsql pgsql \
    # Redis
    && pecl install -o -f redis \
	&&  rm -rf /tmp/pear \
	&&  docker-php-ext-enable redis

# Clear cache and Get latest Composer
# RUN apt-get clean && rm -rf /var/lib/apt/lists/* \
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Create system user to run Composer and Artisan Commands
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Configure cron
COPY ./docker/php/cron /etc/cron.d/cron
RUN chmod 0644 /etc/cron.d/cron \
    && crontab -u www-data /etc/cron.d/cron \
    && chmod u+s /usr/sbin/cron

# Set working directory
WORKDIR /var/www

USER www-data

ENTRYPOINT [ "./docker/php/entrypoint.sh" ]
