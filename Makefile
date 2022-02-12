start:
	php artisan serve --host 0.0.0.0

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
#	touch database/database.sqlite
#	php artisan migrate
#	php artisan db:seed
#	npm ci

migrate:
	php artisan migrate

console:
	php artisan tinker

test:
	php artisan test

deploy:
	git push heroku

lint:
	composer run-script phpcs -- --standard=PSR12 app

lint-fix:
	composer phpcbf
