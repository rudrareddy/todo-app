Steps to install the app

1. Clone the project from Github using HTTP or SSH

    Http URL : https://github.com/rudrareddy/todo-app.git
    SSH URL : git@github.com:rudrareddy/todo-app.git

2. After Cloning the project we need install the composer using below command
    composer install

3. After composer installing the we need to create .env file in the root directory

4. Once .env file created we need to add Database credentials and application name.

5. Then we need to run below command basic setup for project

      1. php artisan key:generate
      2. php artisan config:clear
      3 php artisan config:cache
      4. php artisan view:clear
      5. php artisan migrate

6. All the setup in done, we need to project using below command

      php artisan serve         
