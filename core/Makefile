# To specify text which are not real files or dir
.PHONY: install help up build prune down

# make|make help, Displays help
.DEFAULT_GOAL = help

# Docker and docker-compose files are in the parent dir
DOCKER_COMPOSE =  cd ..; docker-compose
DOCKER =  cd ..; docker

vendor: composer.json ## Install application dependencies
	composer install

composer.lock: composer.json
	composer update

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

install: vendor composer.lock  ## Install application

up: down ## Wakes up containers in the detached mode
	$(DOCKER_COMPOSE) up -d

build: down prune ## Builds images
	$(DOCKER_COMPOSE) build

prune: down ## Cleans up unused containers and images
	$(DOCKER) system prune -a -f

down: ## Switches off all running containers
	$(DOCKER_COMPOSE) down

bash:
	$(DOCKER_COMPOSE) exec php bash

fixtures: migration ## Makes data available for the application
	$(DOCKER_COMPOSE) exec -T php ./bin/console doctrine:fixtures:load --no-interaction

migration: db-drop db-create ## Updates database schema
	$(DOCKER_COMPOSE) exec -T php ./bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

db-drop: ## Drops mysql database
	$(DOCKER_COMPOSE) exec -T php ./bin/console doctrine:database:drop --if-exists --force

db-create: ## Creates mysql database
	$(DOCKER_COMPOSE) exec -T php ./bin/console doctrine:database:create --if-not-exists
