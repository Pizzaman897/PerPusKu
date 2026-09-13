<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Murid - PerPusKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#EDF1FD]">

    {{-- ============== TOPBAR ============== --}}
    <header class="h-[90px] bg-white px-[50px] flex items-center justify-between">
        <div class="text-[22px] font-bold text-[#051541]">
            📖 PerPusKu
        </div>

        <div class="flex items-center gap-[15px] font-bold text-[#051541]">
            <span>Halo, {{ auth()->user()->name ?? 'Admin' }}</span>
            <img
                src="{{ auth()->user()->foto ?? 'https://i.pravatar.cc/100?img=12' }}"
                alt="Foto profil admin"
                class="w-[42px] h-[42px] rounded-full object-cover"
            >
        </div>
    </header>

    <div class="flex min-h-screen">
        {{-- ============== SIDEBAR ============== --}}
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col">

            <nav class="flex-1 px-4 pt-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#051541] hover:bg-[#EDF1FD] font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10" />
                    </svg>
                    Dasbor
                </a>

                <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#051541] hover:bg-[#EDF1FD] font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Buku
                </a>

                <a href="{{ route('admin.status.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#051541] hover:bg-[#EDF1FD] font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status
                </a>

                <a href="{{ route('admin.kelola-admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#051541] hover:bg-[#EDF1FD] font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Admin
                </a>

                <a href="{{ route('admin.kelola-murid.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-[#4748D9] font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347M4.26 10.147a48.47 48.47 0 011.5-.845m-1.5.845a48.5 48.5 0 00-1.5.845M4.26 10.147L12 14.75l7.74-4.603" />
                    </svg>
                    Murid
                </a>
            </nav>

            <div class="px-4 pb-6">
                <a href="{{ route('admin.logout') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#051541] hover:bg-[#EDF1FD] font-medium"
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

        {{-- ============== MAIN CONTENT ============== --}}
        <main class="flex-1 p-8">
            <div class="w-full rounded-2xl bg-white p-10 shadow-sm">

                <a href="{{ route('admin.kelola-murid.index') }}"
                   class="mb-4 inline-flex items-center gap-1 text-base font-bold text-[#4748D9] hover:text-[#151B72]">
                    ← Kembali
                </a>

                <h1 class="mb-8 text-3xl font-extrabold text-[#051541]">Detail Murid</h1>

                <div class="max-w-xl space-y-6">
                    <div>
                        <span class="mb-2 block text-base font-bold text-[#051541]">Murid</span>
                        <div class="w-full rounded-lg border-2 border-[#051541] bg-[#EDF1FD] px-4 py-3 text-base text-[#051541]">
                            {{ $student['name'] }}
                        </div>
                    </div>

                    <div>
                        <span class="mb-2 block text-base font-bold text-[#051541]">Email</span>
                        <div class="w-full rounded-lg border-2 border-[#051541] bg-[#EDF1FD] px-4 py-3 text-base text-[#051541]">
                            {{ $student['email'] }}
                        </div>
                    </div>

                    <div>
                        <span class="mb-2 block text-base font-bold text-[#051541]">NIS</span>
                        <div class="w-full rounded-lg border-2 border-[#051541] bg-[#EDF1FD] px-4 py-3 text-base text-[#051541]">
                            {{ $student['nis'] }}
                        </div>
                    </div>

                    <div>
                        <span class="mb-2 block text-base font-bold text-[#051541]">Status pinjam</span>
                        <div class="w-full rounded-lg border-2 border-[#051541] bg-[#EDF1FD] px-4 py-3 text-base text-[#051541]">
                            {{ $student['status_pinjam'] === 'dipinjam' ? 'Sedang Meminjam' : 'Tidak Meminjam' }}
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.kelola-murid.edit', $student['id']) }}"
                           class="rounded-lg bg-[#4748D9] px-8 py-3 text-base font-bold text-white hover:bg-[#151B72] transition">
                            Edit Murid
                        </a>

                        <form action="{{ route('admin.kelola-murid.destroy', $student['id']) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus murid ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-lg border-2 border-red-500 px-8 py-3 text-base font-bold text-red-500 hover:bg-red-50 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>