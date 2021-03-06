# tentacode.dev

**If you see a typo, don't hesitate to ask for a pull request. 🙏**

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
```