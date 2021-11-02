#!/bin/bash

set -e

composer install --no-interaction
composer dump-autoload
bin/console cache:clear
php-fpm
