# Instalación de Laravel en Ubuntu 20.04
# Este script instala un servidor LEMP con Laravel en Ubuntu 20.04

# Actualizar el sistema
# Instalación de paquetes necesarios

apt-get update

apt-get install redis git curl wget unzip nginx mysql-server supervisor -y

# Instalación de PHP 8.2 y paquetes necesarios que Laravel necesita

add-apt-repository ppa:ondrej/php
apt-get update
apt-get -y install php8.2-{cli,common,fpm,mysql,mbstring,zip,gd,curl,dev,pgsql,sqlite3,imap,bcmath,soap,intl,readline,gmp,redis,memcached,memcache}
apt install php8.2-xml

# Instalación de Composer

cd ~

curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php

HASH=`curl -sS https://composer.github.io/installer.sig`

php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Instalación de de proyecto Laravel

composer install

cp .env.example .env
php artisan key:generate
chmod -R 775

# Configuración de MySQL

ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'testroot';

# Configuracion de Nginx
# Este debe de ir en /etc/nginx/sites-available/default
# Luego de configurar se debe de reiniciar el servicio de nginx
# service nginx restart

server {
    server_name diploy.sh;
    root /var/www/cf-laravel-integrador/public;

    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

# Instalación de Node

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash

nvm install 20

# Configuración de supervisor

[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/cf-laravel-integrador/artisan queue:work
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/root/worker.log
stopwaitsecs=3600

# Para finalizar se debe de ejecutar los siguientes comandos

sudo supervisorctl reread
 
sudo supervisorctl update
 
sudo supervisorctl start "laravel-worker:*"
