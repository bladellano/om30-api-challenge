include laravel-app/.env

setup:
	@make build
	@make up 
	@make composer-update
	@make perm-storage
	@make data
	@make msg
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
	docker exec laravel-app bash -c "composer update && php artisan key:generate"	
data:
	docker exec laravel-app bash -c "php artisan migrate"
	docker exec laravel-app bash -c "php artisan db:seed"
perm-storage:
	docker exec -t laravel-app bash -c 'chown -R www-data:www-data /var/www/html/storage'	
in:
	docker exec -it laravel-app bash
redis:
	docker exec -it redis bash
purge:
	docker-compose down --rmi all
queue:
	docker exec laravel-app bash -c "php artisan queue:work"
test:
	docker exec -t laravel-app bash -c "php artisan test"
msg:
	@echo ":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::"
	@echo ":::::: Clique aqui para ver a api funcionando ${APP_URL}/api ::::::"
	@echo ":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::"


