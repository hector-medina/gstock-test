# GSTOCK-TEST

This repository contains an API with the specs asked for a vacancy in gstock. 

The infrastucture has been developed as follows:
- gstock_api: API container.
- gstock_db: MySQL database.
- gstock_phpmyadmin: phpMyAdmin client for MySQL database.

## Installation.

In order to install the API, you should follow the next steps:

1. Clone this repository.

```sh
git clone https://github.com/hector-medina/gstock-test.git
```

2. Get into the project's folder.

```sh
cd gstock-test
```

3. Run the container.

This command will create three containers: api, MySQL database and phpMyAdmin containers. 

```sh
docker-compose up
```

4. Install dependencies.

- If you have installed [Composer](https://getcomposer.org/) installed, just run: 
```sh
composer install
```
- If you NOT have composer installed in your host machine, then you should run the 
command inside the container. To do so, first you have to get your container ID:
```sh
docker ps
```
Then you should connect to your container :
```sh
docker exec -it <CONTAINER_ID> bash
```

or simply
```sh
docker exec -it gstock_api bash
```

And then you can install dependencies with composer:
```sh
composer install
```
5. Visit your site.

Now you are able to access your site by typing http://localhost:8000
