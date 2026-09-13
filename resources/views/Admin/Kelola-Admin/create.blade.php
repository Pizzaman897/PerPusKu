<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin - PerPusKu</title>
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

                <a href="{{ route('admin.kelola-admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-[#4748D9] font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Admin
                </a>

                <a href="{{ route('admin.murid.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#051541] hover:bg-[#EDF1FD] font-medium">
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

                <a href="{{ route('admin.kelola-admin.index') }}"
                   class="mb-4 inline-flex items-center gap-1 text-base font-bold text-[#4748D9] hover:text-[#151B72]">
                    ← Kembali
                </a>

                <h1 class="mb-8 text-3xl font-extrabold text-[#051541]">Tambahkan Admin</h1>

                @if ($errors->any())
                    <div class="mb-6 max-w-xl rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 max-w-xl rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.kelola-admin.store') }}" class="max-w-xl space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-base font-bold text-[#051541]">Admin</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               placeholder="Nama admin..."
                               class="w-full rounded-lg border-2 border-[#051541] bg-[#EDF1FD] px-4 py-3 text-base text-[#051541] placeholder-slate-500 focus:border-[#4748D9] focus:outline-none focus:ring-2 focus:ring-[#4748D9]/30">
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-base font-bold text-[#051541]">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               placeholder="Email..."
                               class="w-full rounded-lg border-2 border-[#051541] bg-[#EDF1FD] px-4 py-3 text-base text-[#051541] placeholder-slate-500 focus:border-[#4748D9] focus:outline-none focus:ring-2 focus:ring-[#4748D9]/30">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="rounded-lg bg-[#4748D9] px-8 py-3 text-base font-bold text-white hover:bg-[#151B72] transition">
                            Tambahkan Admin
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>