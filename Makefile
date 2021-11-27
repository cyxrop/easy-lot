.PHONY: php pg nginx

php:
	docker exec -it easy-lot-php bash

pg:
	docker exec -it easy-lot-pg psql -h 127.0.0.1 -U cyxrop -d easy_lot

nginx:
	docker exec -it easy-lot-nginx bash

fresh-test-db:
	docker exec -it -e DB_DATABASE=test easy-lot-php php artisan migrate:fresh
