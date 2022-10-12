## About Monochrome

MonoCRM - Membership Management System for Monospace

## Technology stack

Laravel 9 + Laravel Jetstream (Livewrie + Blade) + Laravel Nova

## PHP extension
php 8
- php-zip php-dom php-curl php-mysql php-mbstring

## Project set up

Nova setup need email and license
```
composer config http-basic.nova.laravel.com your-nova-account-email@your-domain.com your-license-key
```
install package
```
composer install

cp .env.example .env
```

install & build Vite
```
npm install && npm run build
```

setting your `.env` file
```
DB_DATABASE=monochrome
DB_USERNAME=<your db account>
DB_PASSWORD=<your db password>
```
run serve
```
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

clean database
```
php artisan db:wipe
```

fresh database with seed
```
php artisan migrate:fresh --seed
```

rollback all migrations and re run the migrations + seed
```
php artisan migrate:refresh --seed
```

## Document - swagger docs
generate api docs
```
php artisan l5-swagger:generate
```

## devcontainer docs

enable mariadb
```
sudo service mariadb status
sudo service mariadb start
sudo mysql_secure_installation
```
follow [ubuntu install mariadb](https://www.digitalocean.com/community/tutorials/how-to-install-mariadb-on-ubuntu-22-04#step-2-configuring-mariadb) to set mysql_secure_installation

create database user and database
```
sudo mariadb
GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;
FLUSH PRIVILEGES;
CREATE DATABASE monochrome;
exit;
```

enable project git
```
git status
git config --global --add safe.directory /workspaces/post-backend
```

disable git config autocrlf
```
git config --global --list
git config --global core.autocrlf false
git config --global core.editor vim
```

now, you can follow README.md set up

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Laravel Jetstream is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
