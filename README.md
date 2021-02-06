# Assertive Creativity Backend

#### Technologies And Dependencies
- PHP 7.4+
- Composer
- Mysql / Postgresql / Sqlite
- [Laravel 8](https://laravel.com/docs/8.x)
- [Postman](https://www.postman.com/)

### Setup & Install

##### Prerequisites
- [Composer](https://getcomposer.org/)
- [PHP 7.4+](https://www.php.net/)

##### Configure .env
- set aws **AWS_ACCESS_KEY_ID**, **AWS_SECRET_ACCESS_KEY**, **AWS_DEFAULT_REGION** and **AWS_BUCKET**
- set **APP_URL** with current host name
- set **DB_CONNECTION**, **DB_HOST**, **DB_PORT**, **DB_DATABASE**, **DB_USERNAME** and **DB_PASSWORD** ( If necessary, add corresponding PHP Database plugin for database.)

##### Laravel Installation
Install laravel. Refer [this](https://laravel.com/docs/8.x/installation). Also install/enable necessary PHP plugins to run laravel.

##### Install Dependency Packages
Install project dependency packages by running `composer install`

##### Database Migration
Migrate database using 
`php artisan migrate:fresh --seed`
This command create table, if there are table exists with data. `:fresh` command will drop all existing tables in the database. `--seed` command will seed intial data including admin credentials (Recommanded) .
You can refer more about migrations in [Laravel Migration Documentation](https://laravel.com/docs/8.x/migrations)

##### JWT Secret Key Generation
JWT (Json Web Token) secret key can be generated using `php artisan jwt:secret` command. You can learn more about the implementation of JWT in [jwt-auth](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/).

##### Storage Access
Create a symbolic link for accessing files outside website. [Read more](https://laravel.com/docs/8.x/filesystem#the-public-disk)
`php artisan storage:link`

##### Start Server
To start the server, use `php artisan serve`

### Documentation
You can import postman api collection from `<project_directory>/doc/assertive.json`

