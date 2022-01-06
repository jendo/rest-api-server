#VARIABLES
RED  := ${shell tput -Txterm setaf 1}
GREEN  := ${shell tput -Txterm setaf 2}
YELLOW := ${shell tput -Txterm setaf 3}
BLUE   := ${shell tput -Txterm setaf 4}

EOL  := ${shell tput -Txterm sgr0}

PHP_CONTAINER_ID = ${shell docker ps -q -f name=php}
PHP_DOCKER_EXEC = docker exec -it ${PHP_CONTAINER_ID}

up:
	@docker-compose up -d --force-recreate --build --remove-orphans

down:
	@docker-compose down --volumes --remove-orphans

php-bash:
	@echo "${GREEN}>>> Entering php container bash${EOL}"
	@$(PHP_DOCKER_EXEC) bash
