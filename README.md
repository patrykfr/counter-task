Installation
------------
.env.dist copy to .env

    1. docker-compose up --build
    2. docker exec -it php-app sh
    3. composer install
    4. bin/console doctrine:migrations:migrate

Usage
-----

    1. http://localhost:8000/register -> sing up
    2. http://localhost:8000/admin/counters
