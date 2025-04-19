bash:
	docker compose exec app bash

migrate:
	docker compose exec app bash -c "cd ./src && php artisan migrate"

migrate-prev:
	docker compose exec app bash -c "cd ./src && php artisan migrate:rollback"

build:
	docker compose --env-file ./.docker/.env.development build

up:
	docker compose --env-file ./.docker/.env.development up -d

down:
	docker compose down

ps:
	docker compose ps
