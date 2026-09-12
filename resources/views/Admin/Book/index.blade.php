<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f7f7] text-[#111111] font-sans">

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

<div class="flex min-h-screen">
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col">

        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10" />
                </svg>
                Dasbor
            </a>

            <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-indigo-600 text-white font-medium">
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

            <a href="{{ route('admin.kelola-admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
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

    <div class="flex-1 flex flex-col">
        <main class="flex-1 p-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 text-green-700 px-4 py-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Kelola Buku</h1>

                <a href="{{ route('admin.buku.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-3 rounded-lg shadow-sm transition">
                    <span class="text-lg leading-none">+</span> Tambahkan Buku
                </a>
            </div>

            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-indigo-100 text-gray-800 text-sm font-semibold">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Judul</th>
                            <th class="px-6 py-4">Jenis</th>
                            <th class="px-6 py-4">Deskripsi</th>
                            <th class="px-6 py-4">URL</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800 font-medium">
                        @forelse ($books as $book)
                            <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-indigo-50/60' : 'bg-white' }}">
                                <td class="px-6 py-4">{{ $loop->iteration }}.</td>
                                <td class="px-6 py-4">{{ $book['title'] }}</td>
                                <td class="px-6 py-4">{{ $book['category'] }}</td>
                                <td class="px-6 py-4">{{ $book['description'] ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ $book['url gambar'] ?? '#' }}" target="_blank" class="text-indigo-600 hover:underline">
                                        URL NYA
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($book['status'] === 'ada')
                                        <span class="text-green-600 font-semibold">Tersedia</span>
                                    @else
                                        <span class="text-red-500 font-semibold">Tidak Tersedia</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.buku.edit', $book['id']) }}" class="text-gray-700 hover:text-indigo-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.buku.destroy', $book['id']) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

</body>
</html>