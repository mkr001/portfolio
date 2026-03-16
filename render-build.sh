#!/usr/bin/env bash
# exit on error
set -o errexit

echo "--- Installing PHP dependencies ---"
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "--- Installing JS dependencies & Building Assets ---"
npm install
npm run build

echo "--- Running Migrations ---"
# Note: Migrations will run if the database is configured
php artisan migrate --force

echo "--- Caching Laravel ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache
