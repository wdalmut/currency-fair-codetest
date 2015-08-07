socket_start:
	cd ./rt && node server.js

socket_build:
	cd ./rt; \
	npm install

web_start:
	php -S 0.0.0.0:8085 -t frontend

backend_start:
	php -S 0.0.0.0:8080 -t backend/public

backend_build:
	cd ./backend; \
	composer install

backend_test:
	cd ./backend; \
	vendor/bin/phpunit
