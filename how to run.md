# Installation Steps

1. `composer install` to install all dependencies
2. `copy .env from .env.example` to add your database connection DB_USERNAME and DB_PASSWORD
3. `php artisan key:generate` to generate an app key
4. `php artisan migrate --seed --force` to migrate the database , seed it with default data and force create schema if not exists
5. `php artisan passport:generate-personal-access-env` to generate a passport personal access token and add it to your .env  
6. `php artisan optimize:clear` to Clearing cached bootstrap files
7. `composer dev` to run your dev server with required dependencies

## How to run testcases
### after any things you must create .env.testing file from .env.example and run
    `php artisan key:generate --env=testing`
#### you can setup your test environment manual by the following steps: 
1. `php artisan migrate --seed --env=testing --force` to migrate the database , seed it with default data and force create schema if not exists
2. `php artisan passport:generate-personal-access-env --env=testing` to generate a passport personal access token and add it to your .env  
3. `php artisan optimize:clear --env=testing` to Clearing cached bootstrap files
4. `php artisan test --env=testing --stop-on-failure` to run the tests
## or `composer test`  for config all things and run tests
