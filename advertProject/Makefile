SYMFONY         = $(EXEC_PHP) bin/console

db: ## Reset the database dev and load fixtures
db: .env vendor
	@$(SYMFONY) doctrine:cache:clear-metadata
	@$(SYMFONY) doctrine:database:create --if-not-exists
	@$(SYMFONY) doctrine:schema:drop --force
	@$(SYMFONY) doctrine:schema:create
	@$(SYMFONY) doctrine:schema:validate
	@$(SYMFONY) doctrine:fixtures:load --no-interaction

## Reset the database test and load fixtures
	@$(SYMFONY) doctrine:database:create --env=test --if-not-exists
	@$(SYMFONY) doctrine:schema:drop --env=test --force
	@$(SYMFONY) doctrine:schema:create --env=test
	@$(SYMFONY) doctrine:schema:validate --env=test
	@$(SYMFONY) doctrine:fixtures:load --env=test --no-interaction
