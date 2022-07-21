<?php
if(!file_exists("config/jwt")){
    shell_exec("php bin/console lexik:jwt:generate-keypair");
}


shell_exec("php-fpm -F -R");


