#VARIABLES
RED  := ${shell tput -Txterm setaf 1}
GREEN  := ${shell tput -Txterm setaf 2}
YELLOW := ${shell tput -Txterm setaf 3}
BLUE   := ${shell tput -Txterm setaf 4}

EOL  := ${shell tput -Txterm sgr0}

DB_SERVICE_NAME = db
PHP_SERVICE_NAME = php
PHP_DOCKER_EXEC = docker compose exec -u www-data -it ${PHP_SERVICE_NAME}
PHP_DOCKER_EXEC_XDEBUG = docker compose exec -e XDEBUG_TRIGGER=1 -u www-data -it ${PHP_SERVICE_NAME}

up:
	@docker-compose --env-file=.env up -d --force-recreate --build --remove-orphans

down:
	@docker-compose --env-file=.env down --volumes --remove-orphans

php-bash:
	@echo "${GREEN}>>> Entering php container bash${EOL}"
	@$(PHP_DOCKER_EXEC) bash

php-bash-xdebug:
	@echo "${GREEN}>>> Entering php container bash${EOL}"
	@$(PHP_DOCKER_EXEC_XDEBUG) bash

db-bash:
	@echo "${GREEN}>>> Entering db container bash${EOL}"
	@docker compose exec -it ${DB_SERVICE_NAME} bash

db-mysql-as-root:
	@echo "${GREEN}>>> Connecting to mysql as root${EOL}"
	@docker compose exec -it ${DB_SERVICE_NAME} mysql -u root -p
