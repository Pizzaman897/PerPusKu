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
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg text-gray-900">
                <img src="{{ asset('images/logo-perpusku.png') }}" alt="Logo PerPusKu" class="h-8 w-auto">
                <span>PerPusKu</span>
            </a>                <h1 class="mt-2 text-3xl font-bold">Dashboard Murid</h1>
                <p class="mt-2 text-slate-600">Selamat datang di dashboard murid.</p>
            </header>

            <section class="grid gap-5 sm:grid-cols-2">
                @forelse ($books as $book)
                    <a href="{{ route('student.book.show', $book['id']) }}"
                       class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] p-4 hover:shadow-[0_5px_15px_rgba(0,0,0,0.12)] transition block">

                        <img src="{{ $book['url gambar'] }}"
                             alt="{{ $book['title'] }}"
                             class="w-full h-64 object-cover rounded-[10px] mb-4">

                        <h3 class="font-bold truncate">
                            {{ $book['title'] }}
                        </h3>

                        <p class="text-[#888888] mt-1">
                            {{ $book['source'] }}
                        </p>

                        <div class="flex items-center gap-2 mt-3">
                            <span class="w-2.5 h-2.5 rounded-full {{ $book['status'] === 'ada' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            <span>
                                {{ $book['status'] === 'ada' ? 'Tersedia' : 'Dipinjam' }}
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="text-[#888888] col-span-4">Belum ada buku.</p>
                @endforelse
            </div>

        </main>
    </div>

</body>
</html>