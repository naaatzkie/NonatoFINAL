<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lost & Found') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        * { font-family: 'Inter', sans-serif; }
        body { background: #f8faff; }
        .gradient-text {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #3b82f6 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(224, 234, 255, 0.5);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
        }
    </style>
</head>
<body class="antialiased text-gray-900 min-h-screen flex flex-col" style="-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale">
    @include('layouts.navigation')
    <main class="flex-1">{{ $slot }}</main>
    <footer class="bg-white border-t border-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <div style="width:24px;height:24px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                    <svg width="13" height="13" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg>
                </div>
                <span class="text-sm font-semibold text-gray-700">Lost<span class="text-blue-600">&</span>Found</span>
            </div>
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Lost &amp; Found System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
