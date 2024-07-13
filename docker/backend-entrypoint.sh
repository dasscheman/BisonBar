#!/usr/bin/env bash
echo "  ⭐️️️️️⭐️️️️️⭐️️️️️⭐️ VERSIE: 1"
## in de dockerfile worden de dev packages verwijderd, dus die moeten we eerst installeren
composer install

if [ ! -f .env ]; then
    ./docker/docker.env /var/www/.env
fi

# make sure folder permissions are set
echo "⭐️ Set folder access Laravel";
chown www-data /var/www/storage -R
chmod a+w -R /var/www/storage
chmod a+w -R /var/www/vendor

php artisan key:generate
php artisan optimize

echo "⭐️ Run artisan migrate";
php artisan migrate --seed

# run apache in foreground
apache2-foreground
