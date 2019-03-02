current_dir = $(shell pwd)

install:
	composer install

update:
	composer update

tests@phpunit:
	bin/simple-phpunit
	@echo "Results file generated file://$(current_dir)/var/phpunit/build/coverage/index.html"

php-cs-fixer:
	php bin/php-cs-fixer fix
