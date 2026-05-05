<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lost & Found') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f4ff; }
    </style>
</head>
<body class="antialiased text-gray-900 min-h-screen flex flex-col">
    @include('layouts.navigation')
    <main class="flex-1">{{ $slot }}</main>
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; Lost &amp; Found System
    </footer>
</body>
</html>
