#!/usr/bin/env bash
set -e

file_env() {
  local var="$1"
	local fileVar="${var}_FILE"
	local def="${2:-}"
	if [ "${!var:-}" ] && [ "${!fileVar:-}" ]; then
	  echo "error: Both $var and $fileVar are set (but are exclusive)"
	fi
	local val="$def"
	if [ "${!var:-}" ]; then
		val="${!var}"
	elif [ "${!fileVar:-}" ]; then
		val="$(< "${!fileVar}")"
	fi
	export "$var"="$val"
	unset "$fileVar"
}

# Loads various settings that are used elsewhere in the script
# This should be called after mysql_check_config, but before any other functions
docker_setup_env() {
	# Initialize values that might be stored in a file
	file_env 'DB_DATABASE'
	file_env 'DB_USERNAME'
	file_env 'DB_PASSWORD'
#	file_env 'DATAPORTEN_KEY'
#	file_env 'DATAPORTEN_SECRET'
}

docker_setup_env "$@"

chown -R :www-data storage bootstrap/cache
chmod -R g+w storage bootstrap/cache

composer install --no-scripts --no-autoloader --ansi --no-interaction -d /var/www/back
composer dump-autoload -d /var/www/back

if [ ! -f ".env" ]
then
  cp .env.example .env
fi

cd /var/www/back && php artisan key:generate && php artisan migrate --seed

chown -R :www-data storage bootstrap/cache
chmod -R g+w storage bootstrap/cache

#TODO this chgrp is bad thing.
#cd public
#if [ ! -d "uploads" ]
#then
#  mkdir "uploads"
#fi

cd storage/app
if [ ! -d "public" ]
then
  mkdir "public"
fi

chmod -R ug+rwx public
chown -R :www-data public

cd public
if [ ! -d "images" ]
then
  mkdir "images"
fi

chmod -R ug+rwx images
chown -R :www-data images

php-fpm
