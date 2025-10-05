# Organizations REST API

REST API приложение для справочника организаций, зданий и видов деятельности.

## Требования

- Docker
- Docker Compose

## Установка и запуск

1. Настройте окружение
- cp .env.example .env

2. Соберите и запустите docker контейнеры
- docker-compose up -d

3. Установите зависимости
- docker-compose exec php-fpm bash
- composer install
- php artisan optimize
- php artisan key:generate

4. Запустите миграции
- php artisan migrate --seed

5. Сгенерируйте Swagger
- php artisan l5-swagger:generate

6. Перейдите на http://webserver:7020/api/documentation 
