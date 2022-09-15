## About Monochrome

MonoCRM - Membership Management System for Monospace

## Technology stack

Laravel 9 + Laravel Jetstream (Livewrie + Blade) + Laravel Nova

## Start up

Nova setup
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
DB_USERNAME=root
DB_PASSWORD=xxxxx
```
run serve
```
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Laravel Jetstream is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
