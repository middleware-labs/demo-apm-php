FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    netcat-openbsd \
    default-mysql-client \
    zlib1g-dev \
    libxml2-dev \
    libssl-dev \
    libjson-c-dev \
    pkg-config

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install zip && \
    docker-php-ext-install exif && \
    docker-php-ext-install pcntl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Make sure phpize is available (required by the script)
RUN which phpize || { echo "phpize not found"; exit 1; }

# Create directory for APM script and agent config
RUN mkdir -p /etc/mw-agent


# Copy entrypoint script and set permissions (as root)
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copy application folder
COPY .env.example /var/www/.env
COPY --chown=www:www . /var/www

# Set environment variables for OpenTelemetry
ENV OTEL_PHP_AUTOLOAD_ENABLED=true
ENV OTEL_TRACES_EXPORTER=otlp
ENV OTEL_EXPORTER_OTLP_PROTOCOL=http/json
ENV OTEL_PROPAGATORS=baggage,tracecontext,b3multi
ENV OTEL_SERVICE_NAME=laravel-todo-app
ENV OTEL_EXPORTER_OTLP_ENDPOINT=http://172.17.0.1:9320
ENV COMPOSER_ALLOW_SUPERUSER=1

# Create agent config file
RUN echo "api-key: demo-key\ntarget: http://172.17.0.1:9320" > /etc/mw-agent/agent-config.yaml

# Change current user to www
USER www

# Expose port 9000
EXPOSE 9000

# Start with the entrypoint script
CMD ["/usr/local/bin/docker-entrypoint.sh"]