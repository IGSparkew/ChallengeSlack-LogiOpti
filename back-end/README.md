# Symfony API

## How to use

```
composer update
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

- use `php bin/console lexik:jwt:generate-keypair` to genrate jwt token in API
- use `symfony server:start  ` to genrate jwt token in API

- add JWT_PASSPHRASE in .env

