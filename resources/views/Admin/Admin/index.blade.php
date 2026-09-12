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
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col">

            <nav class="flex-1 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-indigo-600 text-white font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10" />
                    </svg>
                    Dasbor
                </a>

                <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Buku
                </a>

                <a href="{{ route('admin.status.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status
                </a>

                <a href="{{ route('admin.admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Admin
                </a>

                <a href="{{ route('admin.murid.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347M4.26 10.147a48.47 48.47 0 011.5-.845m-1.5.845a48.5 48.5 0 00-1.5.845M4.26 10.147L12 14.75l7.74-4.603" />
                    </svg>
                    Murid
                </a>
            </nav>

            <div class="px-4 pb-6">
                <a href="{{ route('admin.logout') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
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