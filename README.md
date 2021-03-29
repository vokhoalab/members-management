## Setup:
1. run command: composer install
2. create database and config .env file
3. run command: php artisan migrate:fresh --seed
4. run command: php artisan serve

## API Docs
http://127.0.0.1:8000/api/register
Body - Form data
name:vokhoa
email:vokhoa@gmail.com
password:12345678

http://127.0.0.1:8000/api/login
Body - Form data
email:vokhoa@gmail.com
password:12345678

http://127.0.0.1:8000/api/users
http://127.0.0.1:8000/api/permissions
http://127.0.0.1:8000/api/departments
http://127.0.0.1:8000/api/teams
http://127.0.0.1:8000/api/members

