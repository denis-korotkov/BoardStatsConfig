container_name = php81-service
inside = docker compose exec $(container_name)

up:
	@if [ -d "app/migrations" ]; then rm -R app/migrations; fi
	mkdir -p app/migrations
	docker compose up -d
	sleep 10
	$(inside) php bin/console doctrine:migrations:diff
	$(inside) php bin/console doctrine:migrations:migrate
	$(inside) php bin/console doctrine:fixtures:load

down:
	docker compose down