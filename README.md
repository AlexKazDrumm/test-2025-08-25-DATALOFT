# test29 (Laravel 12.x)
Тестовое задание с доп. заданием (привязка авто к пользователю) и простым веб-интерфейсом.

## Запуск
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Доступ
- UI: http://127.0.0.1:8000
- API: http://127.0.0.1:8000/api

Тестовый пользователь:
- Email: test@example.com
- Password: password
