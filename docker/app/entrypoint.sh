#!/usr/bin/env bash

composer install

php artisan migrate

php artisan key:generate

npm install
npm run dev

service cron start
service supervisor start
service php8.1-fpm start

crontab /etc/cron.d/crontab

nginx -g 'daemon off;'
