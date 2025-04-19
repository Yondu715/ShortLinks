# ShortLinks
Микросервис реализует API для создания "коротких" ссылок, по которым осуществляются редиректы.

# Backend
## Стек и зависимости
- PHP (v8.1) - Язык программирования
- Laravel (v10.10.0) - Backend фреймворк
- PgSql (v17) - СУБД

# Проект

## Алиасы
В корне проекта есть файл Makefile, в котором содержатся алиасы для часто используемых команд
![изображение](https://github.com/user-attachments/assets/87bc3ed4-8129-445c-9b60-d125d6409724)

Для их вызова необходимо выполнить
```sh
make {название_команды}
```

## Установка

### Docker
```sh
make build
make up
```

### Laravel
Необходимо зайти в контейнер app
```sh
make bash
cd application
```
Сгенерировать ключ, если он отсутствует
```sh
php artisan key:generate
```

И установить зависимости
```sh
composer install
```

Далее создаем файл .env
```sh
cp .env .env.example
```

Поднимаем миграции
```sh
php artisan migrate
```

## API
#### Запрос
POST /v1/short-links

Authorization: Bearer abc123xyz

Content-Type: application/json

#### Параметры
> | Название      |  Валидация                  | Описание                                                               |
> |---------------|-----------------------------|------------------------------------------------------------------------|
> | url           | required, url, string       | Ссылка, на которую нужно сделать редирект                              |
> | ttl           | nullable, integer, min:1    | Время жизни ссылки (по умолчанию = 30)                                 |

#### Ответы
> | Код ответа    | content-type                      | Ответ                                                                                                        |
> |---------------|-----------------------------------|--------------------------------------------------------------------------------------------------------------|
> | `201`         | `application/json`                | `{"slug": "dfsjewq", "short_link": "http://localhost/zZEwca8Q", "expires_at": "2025-04-20T20:25:15.000000Z"}`|
> | `422`         | `application/json`                | `{"message": "The url field must be a valid URL. (and 1 more error)","errors": ...`                          |
