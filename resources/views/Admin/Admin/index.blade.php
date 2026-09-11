<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor - PerPusKu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f7f7f7] text-[#111111] font-sans">

    <!-- Header -->
    <header class="h-[90px] bg-white px-[50px] flex items-center justify-between">
        <div class="text-[22px] font-bold">
            📖 PerPusKu
        </div>

        <div class="flex items-center gap-[15px] font-bold">
            <span>Halo, {{ auth()->user()->name ?? 'Admin' }}</span>
            <img
                src="{{ auth()->user()->foto ?? 'https://i.pravatar.cc/100?img=12' }}"
                alt="Foto profil admin"
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
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base bg-[#4947d9] text-white font-bold hover:bg-[#4947d9]"
                >
                    ⌂ &nbsp; Dasbor
                </a>

                <a
                    href="{{ route('admin.buku.index') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base hover:bg-[#f0f0f8] transition"
                >
                    📖 &nbsp; Buku
                </a>

                <a
                    href="{{ route('admin.status.index') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base hover:bg-[#f0f0f8] transition"
                >
                    ◉ &nbsp; Status
                </a>

                <a
                    href="{{ route('admin.admin.index') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base hover:bg-[#f0f0f8] transition"
                >
                    ♙ &nbsp; Admin
                </a>

                <a
                    href="{{ route('admin.murid.index') }}"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base hover:bg-[#f0f0f8] transition"
                >
                    🎓 &nbsp; Murid
                </a>

                <a
                    href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center gap-[14px] px-5 py-[14px] rounded-[10px] text-base hover:bg-[#f0f0f8] transition"
                >
                    ⇥ &nbsp; Keluar
                </a>

                <form
                    id="logout-form"
                    action="{{ route('admin.logout') }}"
                    method="POST"
                    class="hidden"
                >
                    @csrf
                </form>

            </nav>
        </aside>

        <!-- Content -->
        <main class="flex-1 px-[50px] py-[35px] max-[700px]:p-[25px]">

            <!-- Cards -->
            <div class="grid grid-cols-3 gap-[25px] mb-[30px] max-[900px]:grid-cols-1">

                <!-- Total Buku -->
                <div class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] p-[22px]">
                    <div class="flex justify-between items-start">

                        <div class="text-[30px] font-bold">
                            {{ $totalBuku ?? 120 }}
                        </div>

                        <div class="w-10 h-10 rounded-lg bg-[#4947d9] text-white flex items-center justify-center text-lg">
                            📘
                        </div>

                    </div>

                    <div class="flex justify-between items-center mt-[18px] text-base">
                        <span>Total buku</span>

                        <a
                            href="{{ route('admin.buku.index') }}"
                            class="font-bold"
                        >
                            Lihat
                        </a>
                    </div>
                </div>

                <!-- Total Murid -->
                <div class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] p-[22px]">
                    <div class="flex justify-between items-start">

                        <div class="text-[30px] font-bold">
                            {{ $totalMurid ?? 220 }}
                        </div>

                        <div class="w-10 h-10 rounded-lg bg-[#4947d9] text-white flex items-center justify-center text-lg">
                            👥
                        </div>

                    </div>

                    <div class="flex justify-between items-center mt-[18px] text-base">
                        <span>Total murid</span>

                        <a
                            href="{{ route('admin.murid.index') }}"
                            class="font-bold"
                        >
                            Lihat
                        </a>
                    </div>
                </div>

                <!-- Buku Dipinjam -->
                <div class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] p-[22px]">
                    <div class="flex justify-between items-start">

                        <div class="text-[30px] font-bold">
                            {{ $bukuDipinjam ?? 34 }}
                        </div>

                        <div class="w-10 h-10 rounded-lg bg-[#4947d9] text-white flex items-center justify-center text-lg">
                            ◐
                        </div>

                    </div>

                    <div class="flex justify-between items-center mt-[18px] text-base">
                        <span>Buku dipinjam</span>

                        <a
                            href="{{ route('admin.status.index') }}"
                            class="font-bold"
                        >
                            Lihat
                        </a>
                    </div>
                </div>

            </div>

            <!-- Peminjaman Terbaru -->
            <div class="bg-white rounded-[10px] shadow-[0_3px_10px_rgba(0,0,0,0.08)] px-7 py-[26px]">

                <h2 class="text-xl font-bold mb-[15px]">
                    Peminjaman Terbaru
                </h2>

                @forelse ($peminjamanTerbaru ?? [] as $peminjaman)

                    <div class="flex items-center py-4 border-b border-[#e5e5e5] last:border-b-0">

                        <img
                            src="{{ $peminjaman->foto }}"
                            alt="Foto {{ $peminjaman->nama_murid }}"
                            class="w-14 h-14 rounded-full object-cover mr-5"
                        >

                        <div class="flex-1">
                            <div class="text-lg font-bold">
                                {{ $peminjaman->nama_murid }}
                            </div>

                            <div class="text-[#888888] mt-1 text-sm">
                                Meminjam buku {{ $peminjaman->judul_buku }}
                            </div>
                        </div>

                        <div class="text-[#888888] text-sm whitespace-nowrap">
                            {{ $peminjaman->tanggal_pinjam }}
                        </div>

                    </div>

                @empty

                    <!-- Data contoh -->
                    <div class="flex items-center py-4 border-b border-[#e5e5e5]">

                        <img
                            src="https://i.pravatar.cc/100?img=68"
                            alt="Foto Rojer Sumatra"
                            class="w-14 h-14 rounded-full object-cover mr-5"
                        >

                        <div class="flex-1">
                            <div class="text-lg font-bold">
                                Rojer Sumatra
                            </div>

                            <div class="text-[#888888] mt-1 text-sm">
                                Meminjam buku serigala
                            </div>
                        </div>

                        <div class="text-[#888888] text-sm whitespace-nowrap">
                            20 Mei 2026
                        </div>

                    </div>

                    <div class="flex items-center py-4 border-b border-[#e5e5e5]">

                        <img
                            src="https://i.pravatar.cc/100?img=47"
                            alt="Foto Avatar Angin"
                            class="w-14 h-14 rounded-full object-cover mr-5"
                        >

                        <div class="flex-1">
                            <div class="text-lg font-bold">
                                Avatar Angin
                            </div>

                            <div class="text-[#888888] mt-1 text-sm">
                                Meminjam buku Avatar
                            </div>
                        </div>

                        <div class="text-[#888888] text-sm whitespace-nowrap">
                            20 Mei 2026
                        </div>

                    </div>

                    <div class="flex items-center py-4 border-b border-[#e5e5e5]">

                        <img
                            src="https://i.pravatar.cc/100?img=11"
                            alt="Foto Edinson Cavani"
                            class="w-14 h-14 rounded-full object-cover mr-5"
                        >

                        <div class="flex-1">
                            <div class="text-lg font-bold">
                                Edinson Cavani
                            </div>

                            <div class="text-[#888888] mt-1 text-sm">
                                Meminjam buku cara main bola
                            </div>
                        </div>

                        <div class="text-[#888888] text-sm whitespace-nowrap">
                            20 Mei 2026
                        </div>

                    </div>

                    <div class="flex items-center py-4">

                        <img
                            src="https://i.pravatar.cc/100?img=9"
                            alt="Foto Snow Fox"
                            class="w-14 h-14 rounded-full object-cover mr-5"
                        >

                        <div class="flex-1">
                            <div class="text-lg font-bold">
                                Snow Fox
                            </div>

                            <div class="text-[#888888] mt-1 text-sm">
                                Meminjam buku Frozen FOX
                            </div>
                        </div>

                        <div class="text-[#888888] text-sm whitespace-nowrap">
                            20 Mei 2026
                        </div>

                    </div>

                @endforelse

            </div>

        </main>
    </div>

</body>
</html>