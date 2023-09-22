<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Framework 9.52.15 - Laravel Vue3 - CRUD using Redmine REST Apis.

In this project there is an implementation of Laravel CRUD operations using Vue3 and redmine rest apis.

## Setup

- Clone or download the code.
```
git clone https://github.com/vikasbadola/laravel-vue-redmine-crud.git
```
- cd to your downloaded code ```cd laravel-vue-redmine-crud```
- run ```docker-compose build```
- run ```docker-compose up -d``` 
- rename .env.example to .env
- go into docker containe ```docker exec -it laravel-vue-redmine-crud-php-1 bash```
- run ```composer install``` (if it fails, then run it again untill it completes)
- run ```php artisan key:generate```
- Setup your database into .env file or create laravel-vue-crud, ```phpmyadmin``` can be accessed using ```http://localhost:8088/``` username - root, password - password
- Run databse migrations and seeders. Migrations can be found within database/migrations. ```php artisan migrate:refresh --seed```
## Redmine setup (This setup is mandatory to consume redmine Apis)
- Redmine login url is below and login details are ```Login: admin, Password: admin```, after this you will be redirected to change your password, set up the new password and login.
  ```
  http://localhost:8080/login
  ```
- Once you are logged in, go to ```administrations->settings``` select ```APT``` tab and check ```Enable REST web service```
 and Enable ```JSONP support``` and save it.
- Go to projects and create a new Project. ```http://localhost:8080/projects/new```
- Go to Issue Statuses ```http://localhost:8080/issue_statuses``` and create one.
- Create Issue Priorities
  ```http://localhost:8080/enumerations/new?type=IssuePriority```
- Create issue tracker ```http://localhost:8080/trackers/new```, select your project while creating it.
- Within docker container run ```php artisan serve --host=0.0.0.0```
- Run outside container ```docker-compose run --rm node install```
- Now, you can access the application using url ```http://localhost:8000/```





- Generate passport keys. 
```
php artisan passport:install --force
```
- Run the project.
```
php artisan serve
```
- This is it, you can now open postman and start testing api endpoints.

## Link to api documentation
- https://documenter.getpostman.com/view/12689694/UzBvH4E5

- Running test cases. 
```
.\vendor\bin\phpunit (windows machine)
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
