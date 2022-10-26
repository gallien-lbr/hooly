start:
	sh ./dc up -d
stop:
	sh ./dc down
php_shell:
	docker exec -it hooly_php_1 sh
doctrine_migration:
	docker exec -it hooly_php_1 bin/console make:migration
doctrine_migrate:
	docker exec -it hooly_php_1 php bin/console d:m:m
doctrine_gen_migration:
	docker exec -it hooly_php_1 php bin/console doctrine:migrations:dump-schema