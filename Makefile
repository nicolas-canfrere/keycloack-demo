.PHONY: help up down install_client install_resource

help: ## this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

up: ## start containers in background
	docker compose up -d --remove-orphans

down: ## stop containers
	docker compose down

install_client:
	docker compose -f docker-compose.yaml exec keycloack_demo_client_app composer install

install_resource:
	docker compose -f docker-compose.yaml exec keycloack_demo_resource_app composer install
