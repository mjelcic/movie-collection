# Set permissions for app folder
chown -R www-data:www-data /application

# Install dependencies
cd /application || exit

while  [ ! -f  "composer.json" ]
do
    echo "Missing composer.json"
done

if [ ! -d "vendor" ]
then
  composer install || exit
fi

#Migrate db
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

#Generate keypair for jwt
if [ ! -d "config/jwt" ]
then
  php bin/console lexik:jwt:generate-keypair
fi

# Start application
php-fpm -F -R
