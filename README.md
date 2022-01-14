# GSTOCK-TEST

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

This command will create two containers: api and database containers. 

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
docker ps -q
```
Then you should connect to your container :
```sh
docker exec -it <CONTAINER_ID> bash
```
And then you can install dependencies with composer:
```sh
composer install
```
