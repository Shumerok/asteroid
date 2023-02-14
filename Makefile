
DOCKER_COMPOSE = docker-compose
DOCKER_EXEC = docker exec -it asteroid_php

build:
	${DOCKER_COMPOSE} build

up:
	${DOCKER_COMPOSE} up -d

down:
	${DOCKER_COMPOSE} down

migrate:
	${DOCKER_EXEC} php artisan migrate

link:
	${DOCKER_EXEC} php artisan storage:link

seed:
	${DOCKER_EXEC} php artisan db:seed

fresh:
	${DOCKER_EXEC} php artisan m:fr --seed

composer:
	${DOCKER_EXEC} composer install

php:
	${DOCKER_EXEC} bash

pause:
	sleep 5

restart:
	make down up

init:
	make build up composer pause migrate seed print link

print:
	@echo Welcome: http://localhost:8080