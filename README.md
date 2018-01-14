# resume
Test assignment

### Как запустить
Скачать проект
Скачать зависимости через [Composer](https://getcomposer.org): `composer install`
Прописать путь до БД в `.env` в переменной `DATABASE_URL`
Создать базу: `php bin/console doctrine:database:create`
Запустить миграции: `php bin/console doctrine:migrations:migrate`
Запустить заполнение базы фикстурами (по желанию): `php bin/console doctrine:fixtures:load`
Запустить сервер: `php bin/console server:run`
