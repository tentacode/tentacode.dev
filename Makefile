.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

start: ## Start the web server in dev envinronment
	bin/console server:start

stop: ## Stop the web server in dev envinronment
	bin/console server:stop

build: ## Build dependencies
	composer install
	npm install --prefix ./frontend/startbootstrap-freelancer
	./frontend/startbootstrap-freelancer/node_modules/.bin/gulp -f ./frontend/startbootstrap-freelancer/gulpfile.js
	mkdir -p ./public/startbootstrap-freelancer/{js,css,vendor}
	\cp ./frontend/startbootstrap-freelancer/js/*.min.js ./public/startbootstrap-freelancer/js
	\cp ./frontend/startbootstrap-freelancer/css/*.min.css ./public/startbootstrap-freelancer/css
	\cp -r ./frontend/startbootstrap-freelancer/vendor ./public/startbootstrap-freelancer/vendor
	mkdir -p ./public/dracula-prism/{js,css}
	\cp ./frontend/dracula-prism/css/dracula-prism.css ./public/dracula-prism/css
	\cp ./frontend/dracula-prism/js/prism.js ./public/dracula-prism/js

build-prod: ## Build dependencies for production environment
	composer install -o
	npm install --prefix ./frontend/startbootstrap-freelancer
	./frontend/startbootstrap-freelancer/node_modules/.bin/gulp -f ./frontend/startbootstrap-freelancer/gulpfile.js
	mkdir -p ./public/startbootstrap-freelancer/{js,css,vendor}
	\cp ./frontend/startbootstrap-freelancer/js/*.min.js ./public/startbootstrap-freelancer/js
	\cp ./frontend/startbootstrap-freelancer/css/*.min.css ./public/startbootstrap-freelancer/css
	\cp -r ./frontend/startbootstrap-freelancer/vendor ./public/startbootstrap-freelancer/vendor
	mkdir -p ./public/dracula-prism/{js,css}
	\cp ./frontend/dracula-prism/css/dracula-prism.css ./public/dracula-prism/css
	\cp ./frontend/dracula-prism/js/prism.js ./public/dracula-prism/js