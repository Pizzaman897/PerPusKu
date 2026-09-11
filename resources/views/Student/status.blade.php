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

            {{-- Body --}}
            <main class="p-10">

                <h1 class="text-3xl font-bold text-gray-900 mb-8">Peminjaman Saya</h1>

                <div class="space-y-6">
                    @forelse ($peminjaman as $item)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                            <div class="flex gap-8">

                                {{-- Cover buku --}}
                                <img src="{{ $item['url_gambar'] }}"
                                     alt="{{ $item['judul_buku'] }}"
                                     class="w-40 h-56 object-cover rounded-lg shadow-md shrink-0">

                                {{-- Info peminjaman --}}
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <div class="grid grid-cols-[180px_1fr] gap-y-3">
                                                <span class="font-bold text-gray-900">Buku</span>
                                                <span class="text-gray-900">: {{ $item['judul_buku'] }}</span>

                                                <span class="font-bold text-gray-900">Tanggal peminjaman</span>
                                                <span class="text-gray-900">: {{ $item['tanggal_pinjam'] }}</span>

                                                <span class="font-bold text-gray-900">Batas kembali</span>
                                                <span class="text-gray-900">: {{ $item['batas_kembali'] }}</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 shrink-0">
                                            <span class="font-bold text-gray-900">Status:</span>
                                            <span class="px-4 py-1.5 rounded-full text-sm font-semibold
                                                {{ $item['status'] === 'meminjam'
                                                    ? 'bg-emerald-100 text-emerald-600'
                                                    : 'bg-gray-100 text-gray-600' }}">
                                                {{ $item['status'] === 'meminjam' ? 'Meminjam' : 'Dikembalikan' }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($item['status'] === 'meminjam')
                                        <form method="POST" action="{{ route('student.history', $item['id']) }}" class="mt-6">
                                            @csrf
                                            <button type="submit"
                                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl transition">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center text-gray-500">
                            Kamu belum meminjam buku apa pun.
                        </div>
                    @endforelse
                </div>

            </main>
        </div>
    </div>

</body>
</html>