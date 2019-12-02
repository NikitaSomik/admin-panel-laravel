#!/usr/bin/env bash

cp -rf ./.env.local ./.env

composer install
mkdir "./storage/app/public/images"
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
