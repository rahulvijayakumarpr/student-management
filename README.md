
## Docker

- Create .env from .env.example with proper DB credentials
- Run `./vendor/bin/sail artisan migrate --seed`
- Run `./vendor/bin/sail up`


## LAMP
- Pull the code in var/www/html folder
- Create .env from .env.example with proper DB credentials
- Run `composer install`
- Run `php artisan migrate --seed`
- Run `php artisan serve`
