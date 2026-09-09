<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900">
        <main class="mx-auto max-w-5xl px-6 py-10"><p class="text-sm font-medium text-slate-500">PerPusKu</p><h1 class="mt-2 text-3xl font-bold">Dashboard Admin</h1><section class="mt-8 grid gap-5 sm:grid-cols-3">
            @foreach ($statistics as $label => $value)<article class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200"><p class="text-sm capitalize text-slate-500">{{ str_replace('_', ' ', $label) }}</p><p class="mt-3 text-4xl font-bold">{{ $value }}</p></article>@endforeach
        </section></main>
    </body>
</html>
