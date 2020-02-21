start:
	composer install && npm install && npm run watch

test:
	vendor/bin/phpunit
