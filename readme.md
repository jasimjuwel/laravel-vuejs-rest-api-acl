# Laravel Authentication, Role Permission, JWT CRUD and Soap Service

 
## What's included 
* [Laravel 5.7](https://laravel.com/docs/5.6)
* [Vue 2](https://vuejs.org)
* [Axios](https://github.com/mzabriskie/axios)
* [Authentication with JWT Token](https://github.com/tymondesigns/jwt-auth)

## Installation:
* Clone the repo
* Copy `.env.example` to `.env`
* Configure `.env`
* Run `php artisan config:cache`
* `cd` to the repo
* Run `composer install --no-scripts`
* Run `php artisan key:generate`
* Run `php artisan migrate --seed`. A user will be seeded so that you can login, where:
    * email is: `admin@mail.com`
    * password is: `123`
* Run `npm install`
* Run `npm run watch`
* View the site by 
    * Either running `php artisan serve` if you are not using vagrant homestead or laravel valet (in a new terminal/command prompt)
    * Otherwise go to your local dev url configured in vagrant

For any problem in laravel setup, please get help from [Laravel](https://laravel.com) site. If that does not work, please create an issue, I will try my best to help.
     
## Note:
Enable Soap-api and openssl in php configuration

I tried to follow the best practices, but any suggestion, modification is highly appreciated.  
