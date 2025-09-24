#!/bin/bash
set -e

# Correct permissions on startup
chown -R www-data:www-data /var/www/html

# Run composer install 
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-interaction --no-progress
fi

# Run npm install 
if [ ! -d "node_modules" ]; then
    npm install
fi

# Execute the CMD from the Dockerfile (which is supervisord)
exec "$@"

