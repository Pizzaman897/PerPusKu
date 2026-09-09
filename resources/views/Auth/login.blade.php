<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="grid min-h-screen place-items-center bg-slate-100 px-6 text-slate-900">
        <main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200"><a href="{{ route('landing') }}" class="text-sm text-blue-600">&larr; Kembali</a><h1 class="mt-6 text-3xl font-bold">Masuk ke PerPusKu</h1><form action="{{ route('login.authenticate') }}" method="POST" class="mt-8 space-y-5">@csrf<label class="block text-sm font-medium">Email<input type="email" name="email" class="mt-2 w-full rounded-lg border-slate-300" required></label><label class="block text-sm font-medium">Password<input type="password" name="password" class="mt-2 w-full rounded-lg border-slate-300" required></label><button type="submit" class="w-full rounded-lg bg-slate-900 px-4 py-3 font-medium text-white">Masuk</button></form></main>
    </body>
</html>
