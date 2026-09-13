<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f7f7f7] text-[#111111] font-sans">

    <!-- Header -->
    <header class="h-[90px] bg-white px-[50px] flex items-center justify-between">
        <div class="text-[22px] font-bold">
            📖 PerPusKu
        </div>

        <div class="flex items-center gap-[15px] font-bold">
            <span>Halo, {{ auth()->user()->name ?? 'Murid' }}</span>
            <img
                src="{{ auth()->user()->foto ?? 'https://i.pravatar.cc/100?img=12' }}"
                alt="Foto profil murid"
                class="w-[42px] h-[42px] rounded-full object-cover"
            >
        </div>
    </header>

    <!-- Layout -->
    <div class="flex max-[700px]:flex-col">

        <!-- Sidebar -->
        <aside class="w-[260px] shrink-0 bg-white min-h-[calc(100vh-90px)] p-[30px_20px] max-[700px]:w-full max-[700px]:min-h-0">
            <nav class="flex flex-col gap-2 max-[700px]:flex-row max-[700px]:flex-wrap">

                <a
                    href="{{ route('student.dashboard') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base transition
                        {{ request()->routeIs('student.dashboard') || request()->routeIs('student.book.show')
                            ? 'bg-[#4947d9] text-white font-bold hover:bg-[#4947d9]'
                            : 'hover:bg-[#f0f0f8]' }}"
                >
                    ⌂ &nbsp; Beranda
                </a>

                <a
                    href="{{ route('student.status') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base transition
                        {{ request()->routeIs('student.status')
                            ? 'bg-[#4947d9] text-white font-bold hover:bg-[#4947d9]'
                            : 'hover:bg-[#f0f0f8]' }}"
                >
                    ✎ &nbsp; Peminjaman
                </a>

                <a
                    href="{{ route('student.history') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base transition
                        {{ request()->routeIs('student.history')
                            ? 'bg-[#4947d9] text-white font-bold hover:bg-[#4947d9]'
                            : 'hover:bg-[#f0f0f8]' }}"
                >
                    ◉ &nbsp; Riwayat
                </a>

                <a
                    href="{{ route('student.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base hover:bg-[#f0f0f8] transition"
                >
                    ⇥ &nbsp; Keluar
                </a>

                <form
                    id="logout-form"
                    action="{{ route('student.logout') }}"
                    method="POST"
                    class="hidden"
                >
                    @csrf
                </form>

            </nav>
        </aside>

        <!-- Content -->
        <main class="flex-1 px-[50px] py-[35px] max-[700px]:p-[25px]">

            {{-- Judul + filter kategori --}}
            <div class="flex items-center justify-between mb-[30px]">
                <h1 class="text-[28px] font-bold">Daftar Buku</h1>

                <div class="relative">
                    <select class="appearance-none bg-white border border-[#e5e5e5] rounded-[10px] pl-5 pr-10 py-[10px] font-bold cursor-pointer focus:outline-none">
                        <option>Semua Kategori</option>
                        <option>Pelajaran</option>
                        <option>Fiksi</option>
                        <option>Non-Fiksi</option>
                    </select>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">▾</span>
                </div>
            </div>

            {{-- Grid daftar buku --}}
            <div class="grid grid-cols-4 gap-[25px] max-[1100px]:grid-cols-2 max-[600px]:grid-cols-1">
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