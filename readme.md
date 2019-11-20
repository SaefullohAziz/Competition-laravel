# About Larastis

Larastis is Laravel Starter Project with Stisla Admin Template implementation.

## Extra Features

- Auto set UUID (Trait included)
- Custom form component (Bootstrap 4)
- Authentication with Argon2 Hashing

## Installation

Clone this repo (over SSH or HTTPS):

`git clone git@github.com:husenisme/larastis.git`

Install composer packages:

`composer update` 

Duplicate .env.example as .env, update the environment variables and set an app key:

`php artisan key:generate`

After that, run all migrations and seed the database:

`php artisan migrate`
`php artisan db:seed`

Or if your database is fresh and you haven't done any work yet, then it's safe to call the commands in a single line:

`php artisan migrate:refresh --seed`

## Credits

- [Laravel](https://github.com/laravel/laravel)
- [Stisla](https://github.com/stisla/stisla)
- [baguetteBox.js](https://github.com/feimosi/baguetteBox.js)
- [Bootstrap FileStyle](https://github.com/markusslima/bootstrap-filestyle)
- [iCheck](https://github.com/fronteed/iCheck/)
- [LaravelCollective HTML](https://github.com/laravelcollective/html)
