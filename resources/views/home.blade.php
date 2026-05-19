<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>

    <body>
        <a href="{{ route('characters') }}">
            Блок 1
        </a>

        <a href="{{ route('testlist') }}">
            Блок 2
        </a>

    </body>

</html>
