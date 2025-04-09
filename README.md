# AmoCRM Leads Viewer

Проект для интеграции с AMO CRM и отображения списка лидов с возможностью фильтрации, сортировки и пагинации.

## Требования

- PHP 8.x
- Composer
- Laravel 8.x или выше
- Учетная запись AMO CRM

## Установка

**Клонируй репозиторий**:
   git clone git@github.com:DanyaErezer/amoCRM.git
   cd amo

## Установи зависимости:

composer install

## Создайте приложение в AMO CRM:

Перейдите в https://your-subdomain.amocrm.ru в раздел "amoМаркет" → "Установленные" → "Создать интеграцию".


## Создай и настроить файл .env на основе .env.example:

cp .env.example .env

AMOCRM_CLIENT_ID=your-client-id
AMOCRM_CLIENT_SECRET=your-client-secret
AMOCRM_REDIRECT_URI=https://your-server-url/amo-auth/callback
AMOCRM_SUBDOMAIN=your-subdomain

## Запустить миграции, сервер и ngrok(или аналог)
    php artisan migrate
    php artisan serve
    ngrok http 8000

# Процесс авторизации
## Перейдите на страницу авторизации:
http://localhost:8000/amo-auth/redirect

### Вам будет предложено авторизоваться в AMO CRM, затем вы получите токен доступа.

### Токен сохраняется на сервере, и вы можете приступить к просмотру лидов.

## Просмотр лидов
### После успешной авторизации перейдите по адресу http://localhost:8000/leads, чтобы увидеть список лидов.

### Лиды можно фильтровать по статусу, дате обновления и количеству на странице.

## Структура проекта
routes/web.php — Маршруты для работы с авторизацией и отображением лидов.

app/Http/Controllers/AmoAuthController.php — Логика авторизации через AMO CRM.

app/Http/Controllers/LeadController.php — Логика получения и отображения лидов.

resources/views/leads/index.blade.php — Шаблон для отображения списка лидов.

public/css/style.css — Простейшие стили для отображения таблицы с лидами.






