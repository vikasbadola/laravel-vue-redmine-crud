## Laravel Framework 9.52.15 - Laravel Vue3 - CRUD using Redmine REST Apis.

In this project there is an implementation of Laravel CRUD operations using Vue3 and redmine rest apis.

## Note
- This was developed and tested using windows machine.
- While using ```docker-compose up``` if you see any error that port is not available then either change the port for that image or look for a solution to kill that running port.
- Pagination is set to 10, so you will be able to see pagination only when your Isues count is greater the 10.

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
![login](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/989f17a3-8d8a-4459-a60f-386dafbd144a)

- Once you are logged in, go to ```administrations->settings``` select ```APT``` tab and check ```Enable REST web service```
 and Enable ```JSONP support``` and save it.
![enableRestEndpoints](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/6cedd870-dba5-4890-b92c-d986a3194cd7)

- Go to projects and create a new Project. ```http://localhost:8080/projects/new```
  ![neProject](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/ad8a1792-05fa-4857-a72a-5a4e2f58341f)
- Go to Issue Statuses ```http://localhost:8080/issue_statuses``` and create one.
  ![issueStatus](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/e229e428-5ed7-4435-b3d4-13cd52c2ba28)
- Create Issue Priorities
  ```http://localhost:8080/enumerations/new?type=IssuePriority```
![addPriority](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/a31cb438-5dec-401a-9266-66864803b3a9)
- Create issue tracker ```http://localhost:8080/trackers/new```, select your project while creating it.
![addTracker](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/aff76c3e-55ab-41fb-972b-dfe3b312bf6f)
- Copy API access key from ```http://localhost:8080/my/account``` to .env and replace with ```REDMINE_API_KEY```
  ![apikeys](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/a05dc899-6825-41c9-98a5-7e6803c95532)
- Within docker container run ```php artisan serve --host=0.0.0.0```
- Run outside container ```docker-compose run --rm node install```
- Now, you can access the application using url ```http://localhost:8000/```
- Perform CRUD here.
## Accesssing local database instead of redmine apis
- go to .env and set ```USE_REDMINE_REST_APIS=false```, now you can use your local databse to perform CRUD. 

## Running test cases
- Within docker container run below:
```
.\vendor\bin\phpunit 
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
