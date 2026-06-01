<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<!-- Указываем язык страницы, основываясь на текущей локали приложения Laravel -->

<head>
    <meta charset="utf-8">
    <!-- Устанавливаем кодировку документа в UTF-8 для поддержки кириллицы и других символов -->

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Заголовок страницы берётся из конфигурации приложения (файл .env -> APP_NAME) -->

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Для лучшей совместимости с браузером Internet Explorer -->

    <meta name="description" content="">
    <!-- Метаописание страницы (желательно заполнять для SEO) -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Делает страницу адаптивной на мобильных устройствах -->

    <!-- Open Graph мета-теги: используются при публикации сайта в соцсетях -->
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Подключение кастомных CSS-файлов из папки public/assets/css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Подключение ресурсов, собранных Vite (официальный сборщик фронтенда Laravel) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Подключение стилей для Livewire (если используются Livewire-компоненты) -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
<!-- Устанавливаем базовый шрифт и сглаживание текста через Tailwind CSS -->

    @include('layouts.header')
    <!-- Подключаем общий заголовок сайта (header), расположенный в resources/views/layouts/header.blade.php -->

    <main class="px-10">
        {{ $slot }}
        <!-- Основной контент страницы будет подставлен сюда из дочернего шаблона -->
    </main>

    @include('layouts.footer')
    <!-- Подключаем подвал сайта (footer), расположенный в resources/views/layouts/footer.blade.php -->

    @livewireScripts
    <!-- Подключаем скрипты для корректной работы Livewire -->
</body>

</html>
