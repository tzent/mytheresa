# Technical test

Requirements:
- `docker` /If you don't have installed docker on your machine, use Google to find how to do it :D/;

Following steps:
- clone or download the source code;
- open the terminal and go to folder `mytheresa/environment`;
- execute `docker-compose up -d --build` /this will create needed containers in your docker/;
- to run the tests, execute from your terminal `docker exec -it products-service vendor/bin/phpunit`;
- the endpoint is accessible on https://localhost/products (used query params are `category` and `price_less_than`)
- to stop the container, execute `docker-compose down`;

That's it. Enjoy! :D