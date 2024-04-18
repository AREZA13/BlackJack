<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>@yield('title')</title>
</head>

<body>
@if ($errors->any())
    <div class="p-4 mb-0 text-sm text-red-800 text-center font-medium bg-red-50 dark:bg-gray-900 dark:text-red-400"
         role="alert">
        @foreach ($errors->all() as $error)
            {{ 'D`oh!!!' . $error }}
        @endforeach
    </div>
@endif
@yield('content')
</body>
</html>
