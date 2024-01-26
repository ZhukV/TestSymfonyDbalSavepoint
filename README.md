Repository for test nested messenger calls.

Setup:

```shell
docker compose up
docker compose exec php bash
```

System open port 8010 to host machine.

Inside container:

```shell
php bin/console doctrine:schema:update --force
php bin/console init
symfony server:start
```

After this, please open `http://localhost:8010/buy` in you browser, get profiler link from headers, open and see doctrine panel (SQL queries).

By default, savepoint disabled, all OK.
Try to enable savepoints into `/config/packages/doctrine.yml` and reload page.
