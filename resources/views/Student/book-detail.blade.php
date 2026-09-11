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

            {{-- Tombol kembali --}}
            <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-2xl font-bold mb-6 w-fit">
                ← Kembali
            </a>

            {{-- Card detail buku --}}
            <div class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] p-[30px]">

                <div class="flex gap-10">
                    {{-- Cover buku --}}
                    <img src="{{ $book['url gambar'] }}"
                         alt="{{ $book['title'] }}"
                         class="w-52 h-72 object-cover rounded-[10px] shadow-md shrink-0">

                    {{-- Info buku --}}
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold mb-4">
                            {{ $book['title'] }}
                        </h1>

                        <p class="text-lg mb-4">
                            Jenis buku：<span>{{ $book['category'] }}</span>
                        </p>

                        <span class="inline-flex items-center w-fit px-4 py-1.5 rounded-full text-sm font-bold mb-8
                            {{ $book['status'] === 'ada'
                                ? 'bg-emerald-100 text-emerald-600'
                                : 'bg-red-100 text-red-600' }}">
                            {{ $book['status'] === 'ada' ? 'Tersedia' : 'Dipinjam' }}
                        </span>

                        <div class="mt-auto">
                            @if($book['status'] === 'ada')
                                <form method="POST" action="{{ route('student.status', $book['id']) }}">
                                    @csrf
                                    <button type="submit"
                                            class="bg-[#4947d9] hover:bg-[#4947d9] text-white font-bold px-8 py-3 rounded-[10px] transition">
                                        Pinjam Buku
                                    </button>
                                </form>
                            @else
                                <button disabled
                                        class="bg-gray-300 text-white font-bold px-8 py-3 rounded-[10px] cursor-not-allowed">
                                    Pinjam Buku
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-4">Deskripsi</h2>
                    <p class="leading-relaxed">
                        {{ $book['description'] }}
                    </p>
                </div>

            </div>

        </main>
    </div>

</body>
</html>