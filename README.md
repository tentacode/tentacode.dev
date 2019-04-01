# tentacode.dev

**If you see a typo, don't hesitate to ask for a pull request. 🙏**

[![Build Status](https://travis-ci.org/tentacode/tentacode.dev.svg?branch=master)](https://travis-ci.org/tentacode/tentacode.dev)

## Run the project

```bash
make build
# make build-prod
make start
```

## Tests

```bash
bin/security-checker security:check
bin/phpstan analyse src/ --level=max
bin/phpcs
bin/phpspec run -fpretty --no-interaction -v
bin/phpunit
```