#VARIABLES
RED  := ${shell tput -Txterm setaf 1}
GREEN  := ${shell tput -Txterm setaf 2}
YELLOW := ${shell tput -Txterm setaf 3}
BLUE   := ${shell tput -Txterm setaf 4}

EOL  := ${shell tput -Txterm sgr0}

DB_CONTAINER_ID = ${shell docker ps -q -f name=db}
PHP_CONTAINER_ID = ${shell docker ps -q -f name=php}
PHP_DOCKER_EXEC = docker exec -u www-data -it ${PHP_CONTAINER_ID}

up:
	@docker-compose --env-file=.env up -d --force-recreate --build --remove-orphans

down:
	@docker-compose --env-file=.env down --volumes --remove-orphans

php-bash:
	@echo "${GREEN}>>> Entering php container bash${EOL}"
	@$(PHP_DOCKER_EXEC) bash

db-bash:
	@echo "${GREEN}>>> Entering db container bash${EOL}"
	@docker exec -it ${DB_CONTAINER_ID} bash

db-mysql-as-root:
	@echo "${GREEN}>>> Connecting to mysql as root${EOL}"
	@docker exec -it ${DB_CONTAINER_ID} mysql -u root -p
