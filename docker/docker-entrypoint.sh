#!/bin/sh
if [ ! -d "config/jwt" ]
then
  php bin/console lexik:jwt:generate-keypair
fi

php-fpm -F -R