#!/usr/bin/env bash

cp -rf ./.env.local ./.env
cd docker
cp -rf ./env-local ./.env
docker-compose down
docker-compose --build --no-cache nginx php-fpm mysql
docker-compose up -d nginx php-fpm mysql
sleep 30
cd ../

composer install
cd docker
docker-compose exec php-fpm mkdir storage/app/public/images
docker-compose exec php-fpm php artisan key:generate
docker-compose exec php-fpm php artisan storage:link
docker-compose exec php-fpm php artisan migrate --seed


