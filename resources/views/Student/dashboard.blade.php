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
            <header class="mb-8">
                <p class="text-sm font-medium text-slate-500">PerPusKu</p>
                <h1 class="mt-2 text-3xl font-bold">Dashboard Murid</h1>
                <p class="mt-2 text-slate-600">Selamat datang di dashboard murid.</p>
            </header>

            <section class="grid gap-5 sm:grid-cols-2">
                @forelse ($books as $book)
                    <article class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                        <img src="{{ $book['url gambar'] }}" alt="Sampul {{ $book['title'] }}" class="h-48 w-full object-cover">
                        <div class="p-6">
                            <p class="text-sm text-slate-500">{{ $book['category'] }}</p>
                            <h2 class="mt-2 text-xl font-semibold">{{ $book['title'] }}</h2>
                            <p class="mt-4 text-sm font-medium {{ $book['status'] === 'ada' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $book['status'] === 'ada' ? 'Tersedia' : 'Sedang dipinjam' }}
                            </p>
                            <a href="{{ route('student.book.show', $book['id']) }}" class="mt-4 inline-block text-sm font-medium text-blue-600">Lihat detail</a>
                        </div>
                    </article>
                @empty
                    <p class="text-slate-600">Belum ada buku.</p>
                @endforelse
            </section>
        </main>
    </body>
</html>
