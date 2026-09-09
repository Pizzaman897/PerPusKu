<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900">
        <main class="mx-auto max-w-5xl px-6 py-10">
            <h1 class="text-3xl font-bold">History Peminjaman</h1>
            <section class="mt-8 grid gap-5 sm:grid-cols-2">
                @foreach ($history as $item)
                    <article class="flex gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-200"><img src="{{ $item['url gambar'] }}" alt="Sampul {{ $item['book'] }}" class="h-28 w-20 rounded-lg object-cover"><div><h2 class="font-semibold">{{ $item['book'] }}</h2><p class="mt-2 text-sm text-slate-500">{{ $item['borrow_date'] }} - {{ $item['return_date'] }}</p><p class="mt-4 text-sm font-medium text-emerald-600">{{ $item['status'] }}</p></div></article>
                @endforeach
            </section>
        </main>
    </body>
</html>
