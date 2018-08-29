## Usage
cron - https://github.com/liebig/cron
<br/>
auth - https://cartalyst.com/manual/sentinel/2.0#introduction
<br/>
error report - https://sentry.io/
<br/>
debug bar  - https://github.com/barryvdh/laravel-debugbar
<br/>
apidoc - http://apidocjs.com
<br/>
php-image-resize - https://github.com/eventviva/php-image-resize
## Установка приложения
1) composer install
2) npm install
3) php artisan api:generatedoc (для генерации актуальной документации)

## Компоненты которые были удалены но будут использоваться в других частях API
Charts - https://erik.cat/projects/Charts/docs/4
<br/>
## В дальнейшем использовать как хостинг файлов
https://www.scaleway.com/virtual-cloud-servers/ (Сервер за 3 евро в месяц, дают 50 гб ssd)
## Управление Iptables через API
https://github.com/plugowski/iptables

## Примечания
Задание - TeamSpeakSnapshotsVirtualServers
Потребляет слишком много ram, из расчета на 1 инстанс 15 мб озу (пиково)
Необходимо реализовать менее требовальный к ram способ сохранения в бд