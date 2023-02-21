
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

seed:
	${DOCKER_EXEC} php artisan db:seed

test:
	${DOCKER_EXEC} php artisan test

fresh:
	${DOCKER_EXEC} php artisan m:fr

composer:
	${DOCKER_EXEC} composer install

php:
	${DOCKER_EXEC} bash

pause:
	sleep 3

restart:
	make down up

init:
	make build up composer migrate print

print:
	@echo http://localhost:8080/api/v1/ - hello
	@echo http://localhost:8080/api/v1/neo/ - set or update data from https://api.nasa.gov/
	@echo http://localhost:8080/api/v1/neo/fastest/ - get fastest asteroids.
	@echo http://localhost:8080/api/v1/neo/fastest?hazardous=true - get fastest and hazardous asteroids order by speed "desc"
	@echo http://localhost:8080/api/v1/neo/fastest?hazardous=false - get fastest and NOT hazardous asteroids order by speed "desc"

