at-js-4-wp-cp
=============

At.js for WordPress by CasePress


## Todo
### Ближайшие
- Выбор пользователя через @
- Далее добавить хук чтобы ссылки превращались в URL при выводе коммента (хранение также оставить обычным текстом)
- ИД пользователей к которым обратились записываются в мету user_request_cp

## Долгий ящик
- Сделать AJAX подбор URL на страницу через #
- ИД постов на которые сделана ссылка записываются в мету post_url_cp
- Добавить скриншоты в описание
- Запросы AJAX должны быть контекстно зависимы. Скажем если ввели символы us, то AJAX запрос должен быть ?name=us и запрос к БД должен идти к юзерам содержащим us.
