<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900">
        <main class="mx-auto max-w-4xl px-6 py-10">
            <a href="{{ route('student.dashboard') }}" class="text-sm text-blue-600">&larr; Kembali ke dashboard</a>
            <section class="mt-6 grid gap-8 rounded-2xl bg-white p-6 shadow-sm sm:grid-cols-[220px_1fr] sm:p-8">
                <img src="{{ $book['url gambar'] }}" alt="Sampul {{ $book['title'] }}" class="aspect-[3/4] w-full rounded-xl object-cover">
                <div>
                    <p class="text-sm text-slate-500">{{ $book['category'] }}</p>
                    <h1 class="mt-2 text-3xl font-bold">{{ $book['title'] }}</h1>
                    <p class="mt-5 leading-7 text-slate-600">{{ $book['description'] }}</p>
                    <p class="mt-6 font-medium text-emerald-600">{{ $book['status'] === 'ada' ? 'Tersedia untuk dipinjam' : 'Sedang dipinjam' }}</p>
                </div>
            </section>
        </main>
    </body>
</html>
