<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Si-Gerdu Pandang') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/Logo.png') }}">

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            .bg-login {
                background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%);
            }
        </style>
    </head>
    <body class="font-sans text-slate-900 antialiased bg-login min-h-screen flex items-center justify-center p-4">
        
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="flex flex-col items-center justify-center mb-8">
                <div class="bg-white p-3 rounded-2xl shadow-sm mb-4">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-16 h-16 object-contain" />
                </div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight text-center">SI GERDU PANDANG</h1>
                <p class="text-sm text-slate-500 mt-1 text-center">Sistem Informasi Gerakan Terpadu Pemeriksaan Darah Tinggi</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-xl shadow-xl shadow-primary-500/5 border border-white p-8 rounded-3xl">
                {{ $slot }}
            </div>
            
            <p class="text-xs text-center text-slate-400 mt-8">
                &copy; {{ date('Y') }} Dinas Kesehatan Kulon Progo. All rights reserved.
            </p>
        </div>

    </body>
</html>
