*Initial*

1. Run composer install
2. Run npm install
3. Run npm run dev
4. Setup your local .env 
5. generate APP_KEY key. run php artisan key:generate
6. Setup Database, same database name with with env
7. Run migration file with seeder, php artisan migrate --seed
8. Run php artisan passport:install

*Credential*

1. Admin 

email: admin@gmail.com

password: abcd1234

2. User 

email: user@gmail.com

password: abcd1234

*For API*

1. Login

POST - {{host}}/api/login

Body
{
    "email": "admin@gmail.com",

    "password": "abcd1234"
}

2. Get list of todo

GEt - {{host}}/api/todo-list