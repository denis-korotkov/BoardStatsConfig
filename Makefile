php_container = php81-service
db_container = database
inside_php = docker compose exec $(php_container)
inside_db = docker compose exec $(db_container)

up:
	@if [ -d "app/migrations" ]; \
		then rm -R app/migrations; \
	fi
	mkdir -p app/migrations
	docker compose up -d
	echo "Waiting for services to be ready..."
	@while ! $(inside_db) mysqladmin ping -h"$(db_container)" --silent; do \
		sleep 1; \
		echo "Waiting for database..."; \
	done
	$(inside_php) php bin/console doctrine:migrations:diff
	$(inside_php) php bin/console doctrine:migrations:migrate
	$(inside_php) php bin/console doctrine:fixtures:load

down:
	docker compose down