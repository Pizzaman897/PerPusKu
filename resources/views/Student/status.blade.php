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

            <h1 class="text-[28px] font-bold mb-[30px]">Peminjaman Saya</h1>

            <div class="space-y-6">
                @forelse ($peminjaman as $item)
                    <div class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] p-8">
                        <div class="flex gap-8">

                            {{-- Cover buku --}}
                            <img src="{{ $item['url gambar'] }}"
                                 alt="{{ $item['judul_buku'] }}"
                                 class="w-40 h-56 object-cover rounded-[10px] shadow-md shrink-0">

                            {{-- Info peminjaman --}}
                            <div class="flex-1 flex flex-col">
                                <div class="flex items-start justify-between gap-6">
                                    <div class="grid grid-cols-[180px_1fr] gap-y-3">
                                        <span class="font-bold">Buku</span>
                                        <span>: {{ $item['judul_buku'] }}</span>

                                        <span class="font-bold">Tanggal peminjaman</span>
                                        <span>: {{ $item['tanggal_pinjam'] }}</span>

                                        <span class="font-bold">Batas kembali</span>
                                        <span>: {{ $item['batas_kembali'] }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="font-bold">Status:</span>
                                        <span class="px-4 py-1.5 rounded-full text-sm font-bold whitespace-nowrap
                                            {{ $item['status'] === 'meminjam'
                                                ? 'bg-emerald-100 text-emerald-600'
                                                : 'bg-gray-100 text-gray-600' }}">
                                            {{ $item['status'] === 'meminjam' ? 'Meminjam' : 'Dikembalikan' }}
                                        </span>
                                    </div>
                                </div>

                                @if($item['status'] === 'meminjam')
                                    <form method="POST" action="{{ route('student.book.kembalikan', $item['id']) }}" class="mt-auto pt-6">
                                        @csrf
                                        <button type="submit"
                                                class="bg-[#4947d9] hover:bg-[#3735b8] text-white font-bold px-6 py-2.5 rounded-[10px] transition">
                                            Kembalikan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] p-8 text-center text-[#888888]">
                        Kamu belum meminjam buku apa pun.
                    </div>
                @endforelse
            </div>

        </main>
    </div>

</body>
</html>