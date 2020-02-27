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
#docker_setup_env() {
#	# Initialize values that might be stored in a file
#	file_env 'DB_DATABASE_MANAGEMENT'
#	file_env 'DB_USERNAME_MANAGEMENT'
#	file_env 'DB_PASSWORD_MANAGEMENT'
#	file_env 'DATAPORTEN_KEY'
#	file_env 'DATAPORTEN_SECRET'
#}

#docker_setup_env "$@"

chown -R :www-data storage bootstrap/cache
chmod -R g+w storage bootstrap/cache

composer install --no-scripts --no-autoloader --ansi --no-interaction -d /var/www/back
composer dump-autoload -d /var/www/back

if [ ! -f ".env" ]
then
  cp .env.example .env
fi


chown -R :www-data storage bootstrap/cache
chmod -R g+w storage bootstrap/cache

cd /var/www/back && mkdir storage/app/public/images && php artisan key:generate && php artisan storage:link && php artisan migrate --seed

php-fpm
