# Тестовое задание для компании AmoPoint.

## Доступ

- Задание доступно по адресу: https://vh653618.eurodir.ru
- Техническое задание: [tz.docx](./tz.docx)

## 1. Загрузка персонажей из API

- API: [rickandmortyapi.com](https://rickandmortyapi.com/)
- [/api/characters](https://vh653618.eurodir.ru/api/characters) отдает список персонажей в формате JSON

## 2. Скрипт для фильтрации полей формы

- страница [/testlist](https://vh653618.eurodir.ru/testlist) демонстрация работы скрипта
- сам скрипт доступен по адресу: https://vh653618.eurodir.ru/js/field-filter.js

## 3. Счетчик посещений и статистика

- Определение локации через сервис https://ipapi.co

Подключение скрипта на сторонний сайт:

```html
<script
    src="https://vh653618.eurodir.ru/js/visitor-tracker.js"
    data-endpoint="https://vh653618.eurodir.ru/api/visits"
    defer
></script>
```
