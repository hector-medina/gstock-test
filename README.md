# GSTOCK-TEST

This repository contains an API with the specs asked for a vacancy in gstock. 

The infrastucture has been developed as follows:
- gstock_api: API container.
- gstock_db: MySQL database.
- gstock_phpmyadmin: phpMyAdmin client for MySQL database.

## Installation.

In order to install the API, you should follow the next steps:

### 1. Clone this repository.

```sh
git clone https://github.com/hector-medina/gstock-test.git
```

### 2. Get into the project's folder.

```sh
cd gstock-test
```

### 3. Run the container.

This command will create three containers: api, MySQL database and phpMyAdmin containers. 

```sh
docker-compose up
```

### 4. Install dependencies.

You should run a command inside the container. To do so, first you have connect to it:
```sh
docker exec -it gstock_api bash
```

And then you can install dependencies with composer:
```sh
composer install
```

### 5. Visit your site.

Now you are able to access your site by typing, but there are currently two enviroment exposed
- http://localhost:80 or http://localhost : Production environment
- http://localhost:8000 : Development environment
