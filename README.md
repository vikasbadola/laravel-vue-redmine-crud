## Laravel Framework 9.52.15 - Laravel Vue3 - CRUD using Redmine REST Apis.

In this project there is an implementation of Laravel CRUD operations using Vue3 and redmine rest apis.

## Note
- This was developed and tested using windows machine.
- While using ```docker-compose up``` if you see any error that port is not available then either change the port for that image or look for a solution to kill that running port.
- Pagination is set to 10, so you will be able to see pagination only when your Isues count is greater the 10.
- You might see slowness in the app this because of running it in windows using WSL. Please wait till the loader fades out.

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
![login](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/8e0a960c-9461-487f-8b52-4800eba508b6)


- Once you are logged in, go to ```administrations->settings``` select ```APT``` tab and check ```Enable REST web service```
 and Enable ```JSONP support``` and save it.

![enableRestEndpoints](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/bdbe4760-85c7-48f1-88d0-2e05b62ed033)

- Go to projects and create a new Project. ```http://localhost:8080/projects/new```
  
![neProject](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/a10f943e-6859-4a32-8220-9f3131c81ddb)

- Go to Issue Statuses ```http://localhost:8080/issue_statuses``` and create one.
  ![issueStatus](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/22debfa4-60bc-4eab-8001-f3a7f84fe9e2)

- Create Issue Priorities
  ```http://localhost:8080/enumerations/new?type=IssuePriority```
![addPriority](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/39dfdd38-c141-4a61-aa7e-4a7f8b78a82a)

- Create issue tracker ```http://localhost:8080/trackers/new```, select your project while creating it.
![addTracker](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/36746791-f1c5-43fa-87eb-6be60f35aa67)

- Copy API access key from ```http://localhost:8080/my/account``` to .env and replace with ```REDMINE_API_KEY```
  ![apikeys](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/f3f6ab7a-7d59-4d7b-ab14-8e6525645efb)

- Within docker container run ```php artisan serve --host=0.0.0.0```
- Run outside container ```docker-compose run --rm node install```
- Now, you can access the application using url ```http://localhost:8000/```
![Issueslist](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/a7f1af91-2927-4697-8ebe-8cb906ec2ffb)


## screenshots of the app and functionality

![addIssue](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/dc561a00-f725-4803-9fbf-857ff4e97963)
![issueListPaginator](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/ce983d99-aa65-4f88-9300-e872d001c927)
![IssueListNopaginator](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/8e37d790-e751-426c-82c2-89405415c8f8)
![editIssue](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/905cb119-df2a-44ef-b5ce-2afae1bfdb2c)
![deleteIssue](https://github.com/vikasbadola/laravel-vue-redmine-crud/assets/6604713/71092a13-7e0a-4734-aef5-4decf226a19c)


## Accesssing local database instead of redmine apis
- go to .env and set ```USE_REDMINE_REST_APIS=false```, now you can use your local databse to perform CRUD. 

## Running test cases
- Within docker container run below:
```
.\vendor\bin\phpunit 
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
