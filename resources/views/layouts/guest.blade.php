<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustakaan Sekolah') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-indigo-800 to-indigo-600 px-4 py-8">

            <div class="w-full max-w-md">

                {{-- Logo + Judul --}}
                <div class="text-center mb-6 text-white">
                    <div class="text-5xl mb-2">📚</div>
                    <h1 class="text-2xl font-bold tracking-wide">Perpustakaan Sekolah</h1>
                    <p class="text-indigo-200 text-sm mt-1">Sistem Informasi Pengelolaan Perpustakaan</p>
                </div>

                {{-- Card form --}}
                <div class="bg-white rounded-2xl shadow-2xl p-8">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                <p class="text-center text-xs text-indigo-200 mt-6">
                    &copy; {{ date('Y') }} Perpustakaan Sekolah — UKK RPL Paket A
                </p>
            </div>
        </div>
    </body>
</html>