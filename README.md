at-js-4-wp-cp
=============

At.js for WordPress by CasePress

# Changelog

## 20141008
- ИД пользователей к которым обратились записываются в мету user_request_cp

## 20140801
- первая версия
- Выбор пользователя через @


# Todo
## Ближайшие
- пользователи выбираются в том числе по эл почте и nicename
- Сделать AJAX подбор URL на страницу через #
- ИД постов на которые сделана ссылка записываются в мету post_url_cp
- код связанный с админкой и настройкой вынесен в отдельный файл
- код установки опций и их удаления убран из активации, параметры по умолчанию перенесены в функции

## Долгий ящик
- Добавить скриншоты в описание
- Запросы AJAX должны быть контекстно зависимы. Скажем если ввели символы us, то AJAX запрос должен быть ?name=us и запрос к БД должен идти к юзерам содержащим us.
- При наведении на ключ пользователя, всплывает визитка (опционально)
