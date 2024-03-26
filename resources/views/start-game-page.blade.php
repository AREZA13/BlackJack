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
@if (isset($message))
    {!! $message !!} <br>
@endif
<a href="{{route('get-two-cards-game-page')}}">
    <button type="button" class="btn btn-primary">Start game</button>
</a>
@yield('content')
</body>
<footer>
    @yield('footer')
    <br>
    <a href="/game-delete">
        <button type="button" class="btn btn-warning">Start Over</button>
    </a>
</footer>
</html>
