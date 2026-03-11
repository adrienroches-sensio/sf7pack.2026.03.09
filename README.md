Sensio Event
============

## Install

```console
$ git clone https://github.com/adrienroches-sensio/sf7pack.2026.03.09.git
$ cd ./sf7pack.2026.03.09
$ symfony composer install
$ symfony console doctrine:migration:migrate --allow-no-migration --no-interaction
$ symfony console doctrine:fixtures:load --no-interaction
$ symfony serve
```

## Log in

| username | password | roles      |
|----------|----------|------------|
| admin    | admin    | ROLE_ADMIN |
