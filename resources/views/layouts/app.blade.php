<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >
        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        >
        @stack('styles')
    </head>

    <body class="bg-light">
        @include('partials.header')

        <main class="py-lg-5 container py-4">
            @yield('content')
        </main>

        @stack('scripts')

        <script
            src="/js/visitor-tracker.js"
            data-endpoint="/api/visits"
            defer
        ></script>
    </body>

</html>
