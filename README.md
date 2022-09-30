## About Monochrome

MonoCRM - Membership Management System for Monospace

## Technology stack

Laravel 9 + Laravel Jetstream (Livewrie + Blade) + Laravel Nova

## PHP extension
php 8
- php-zip php-dom php-curl

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

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Laravel Jetstream is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
