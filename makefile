up:
	@docker-compose --env-file=.env up -d --force-recreate --build --remove-orphans

down:
	@docker-compose --env-file=.env down --volumes --remove-orphans
