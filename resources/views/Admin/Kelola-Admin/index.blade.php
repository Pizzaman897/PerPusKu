<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - PerPusKu</title>
    @vite('resources/css/app.css')
    {{-- Kalau belum pakai Vite, ganti baris di atas dengan CDN Tailwind di bawah ini: --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>
<body class="bg-gray-50">

    {{-- ============== TOPBAR ============== --}}
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
        {{-- ============== SIDEBAR ============== --}}
      <aside class="w-64 bg-white border-r border-gray-100 flex flex-col">

            <nav class="flex-1 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
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

                <a href="{{ route('admin.kelola-admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-indigo-600 font-medium">
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

        {{-- ============== MAIN CONTENT ============== --}}
        <main class="flex-1 p-8">

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-3xl font-extrabold text-gray-900">Kelola Admin</h1>
                <button type="button"
                        onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                        class="flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow hover:bg-indigo-700">
                    <span class="text-lg leading-none">+</span> Tambahkan Admin
                </button>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-indigo-100 text-gray-900">
                            <th class="px-6 py-4 font-bold">No</th>
                            <th class="px-6 py-4 font-bold">Admin</th>
                            <th class="px-6 py-4 font-bold">Email</th>
                            <th class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $index => $admin)
                            <tr class="{{ $index % 2 === 1 ? 'bg-indigo-50/60' : 'bg-white' }}">
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ $admins->firstItem() + $index }}.
                                </td>
                                <td class="px-6 py-4 text-gray-800">{{ $admin->name }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $admin->email }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                                onclick="document.getElementById('modal-edit-{{ $admin->id }}').classList.remove('hidden')"
                                                class="text-gray-900 hover:text-indigo-600" title="Edit">
                                            ✏️
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.kelola-admin.destroy', $admin) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Edit per baris --}}
                            <div id="modal-edit-{{ $admin->id }}"
                                 class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
                                <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
                                    <h2 class="mb-4 text-xl font-bold text-gray-900">Edit Admin</h2>
                                    <form action="{{ route('admin.kelola-admin.update', $admin) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama</label>
                                            <input type="text" name="name" value="{{ $admin->name }}" required
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" value="{{ $admin->email }}" required
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                                Password Baru (opsional)
                                            </label>
                                            <input type="password" name="password"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                                Konfirmasi Password
                                            </label>
                                            <input type="password" name="password_confirmation"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                                        </div>
                                        <div class="flex justify-end gap-3 pt-2">
                                            <button type="button"
                                                    onclick="document.getElementById('modal-edit-{{ $admin->id }}').classList.add('hidden')"
                                                    class="rounded-lg px-4 py-2 font-medium text-gray-600 hover:bg-gray-100">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                    class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data admin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $admins->links() }}
            </div>
        </main>
    </div>

    {{-- ============== MODAL TAMBAH ADMIN ============== --}}
    <div id="modal-tambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <h2 class="mb-4 text-xl font-bold text-gray-900">Tambahkan Admin</h2>
            <form action="{{ route('admin.kelola-admin.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:outline-none">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button"
                            onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                            class="rounded-lg px-4 py-2 font-medium text-gray-600 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('modal-tambah').classList.remove('hidden');
            });
        </script>
    @endif

</body>
</html>