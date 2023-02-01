<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    @yield('content')
	<x-modal />
</body>

</html>
