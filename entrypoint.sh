#!/bin/bash

until mysqladmin ping -h mysql --silent; do
  echo 'waiting for mysqld to be connectable...'
  sleep 2
done

php composer.phar install
php artisan migrate:refresh --seed
