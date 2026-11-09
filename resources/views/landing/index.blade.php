<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f5f0e8] text-[#1f2a24]">
        <main class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-6 sm:px-10 lg:px-16">
            <nav class="flex items-center justify-between border-b border-[#1f2a24]/15 pb-5">
                <a href="{{ route('landing') }}" class="text-lg font-semibold tracking-tight">PerPusKu</a>
                <a href="{{ route('login') }}" class="rounded-full bg-[#1f2a24] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#34483d]">
                    Masuk
                </a>
            </nav>

            <section class="grid flex-1 items-center gap-12 py-16 lg:grid-cols-[1.1fr_0.9fr] lg:py-24">
                <div class="max-w-2xl">
                    <p class="mb-5 text-sm font-semibold uppercase tracking-[0.24em] text-[#bd5b3a]">Perpustakaan digital</p>
                    <h1 class="max-w-xl text-5xl font-semibold leading-[1.05] tracking-tight sm:text-6xl">
                        Temukan bacaan yang membuat rasa ingin tahu terus hidup.
                    </h1>
                    <p class="mt-6 max-w-lg text-lg leading-8 text-[#1f2a24]/70">
                        Kelola koleksi, temukan buku, dan pantau peminjaman dalam satu ruang sederhana untuk seluruh warga perpustakaan.
                    </p>
                    <div class="mt-9 flex flex-wrap gap-4">
                        <a href="{{ route('login') }}" class="rounded-full bg-[#bd5b3a] px-6 py-3 font-medium text-white transition hover:bg-[#a94d30]">
                            Mulai menjelajah
                        </a>
                        <span class="flex items-center px-1 text-sm text-[#1f2a24]/55">Untuk murid dan admin</span>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-4xl bg-[#d8e1d5] p-8 sm:p-12">
                    <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full border-20 border-[#bd5b3a]/25"></div>
                    <div class="relative">
                        <p class="text-sm font-medium text-[#1f2a24]/60">Hari ini di perpustakaan</p>
                        <div class="mt-12 border-l-2 border-[#bd5b3a] pl-5">
                            <p class="text-6xl font-semibold tracking-tight">120</p>
                            <p class="mt-2 text-[#1f2a24]/65">koleksi siap dipinjam</p>
                        </div>
                        <div class="mt-12 grid grid-cols-2 gap-4 border-t border-[#1f2a24]/15 pt-5 text-sm">
                            <div>
                                <p class="font-semibold">Murid</p>
                                <p class="mt-1 text-[#1f2a24]/60">Cari dan pinjam buku</p>
                            </div>
                            <div>
                                <p class="font-semibold">Admin</p>
                                <p class="mt-1 text-[#1f2a24]/60">Kelola koleksi dan status</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
