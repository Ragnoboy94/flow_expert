![изображение](https://github.com/Ragnoboy94/flow_expert/assets/108244498/9370a6db-80de-49bc-8756-836b5a4152c2)

# Установка и настройка проекта

Скопировать `.env` файл из `.env.example` и указать настройки

```
cp .env.example .env
```

Прописать в `.env` параметры `APP_HOST`, `DB_PGSQL_EXT_PORT`(`DB_MYSQL_EXT_PORT`) и `COMPOSE_PROJECT_NAME` уникальными значениями

На локальном сервере добавить запись в файл hosts, указав в нём IP домен 127.0.0.1 из настройки `APP_HOST` (Инструкция https://timeweb.com/ru/docs/obshchie-voprosy/nastrojka-fajla-etc-hosts/)

> Либо использовать encrypted файл. Ключ от него отправлен в личку

### Docker

Запустить команду

```
docker-compose up -d --build
```

### Laravel

Заходим внутрь докера, там APP

И запускаем следующие команды

```
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan db:seed
php artisan queue:restart
```

### Cron

**Добавляем команду в crontab**

```
sh docker/cron/crontab.sh
```

> ‼ Внимание, эту команду нужно запускать в корне проекта и только 1 раз

**Включение**

Чтобы включить в файле `.env` проставьте значение `CRON_ENABLE=1`

# Полезные ссылки

Первичная настройка Ubuntu
https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-18-04

Установка Docker в Ubuntu
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04

Установка Git в Ubuntu
https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-18-04

Установка php, nginx, mysql в Docker
https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose-ru

Установка Cron в Ubuntu
https://www.digitalocean.com/community/tutorials/how-to-use-cron-to-automate-tasks-ubuntu-1804
