VENDOR = ./vendor

install: ## Install dependencies without running the whole application.
	composer install

php-cs-fixer: ## Run php fixer.
	${VENDOR}/bin/php-cs-fixer fix src/  --verbose

phpstan: ## Run phpstan
	${VENDOR}/bin/phpstan analyse src --level 4

run-test: ## Run tests
	${VENDOR}/bin/phpunit tests

run-app: ## Run example app
	php app.php input.csv output.json