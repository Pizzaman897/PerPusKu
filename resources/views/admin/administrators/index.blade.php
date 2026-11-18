@extends('layouts.admin')

@section('title', 'Kelola Admin - PerPusKu')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-indigo-600">Akses aplikasi</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Kelola Admin</h1>
            <p class="mt-2 text-sm text-slate-500">Atur akun yang dapat mengelola perpustakaan.</p>
        </div>
        <a href="{{ route('admin.kelola-admin.create') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">Tambah admin</a>
    </div>

    <form method="GET" action="{{ route('admin.kelola-admin.index') }}" class="mb-6 flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-end">
        <div class="flex-1">
            <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">Cari nama atau email</label>
            <input id="search" name="search" type="search" value="{{ $search }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Masukkan nama atau email">
        </div>
        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Filter</button>
        @if ($search !== '')
            <a href="{{ route('admin.kelola-admin.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
        @endif
    </form>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold">ID</th>
                        <th class="px-5 py-4 font-semibold">Admin</th>
                        <th class="px-5 py-4 font-semibold">Email</th>
                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($admins as $admin)
                        <tr class="hover:bg-slate-50/70">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $admin->id }}</td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <a href="{{ route('admin.kelola-admin.show', $admin) }}" class="font-semibold text-slate-800 hover:text-indigo-700">{{ $admin->name }}</a>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $admin->email }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.kelola-admin.show', $admin) }}" class="font-medium text-indigo-600 hover:text-indigo-800">Detail</a>
                                    <a href="{{ route('admin.kelola-admin.edit', $admin) }}" class="font-medium text-slate-600 hover:text-indigo-700">Edit</a>
                                    <form action="{{ route('admin.kelola-admin.destroy', $admin) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-500">Belum ada data admin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    @if ($admins->hasPages())
        <div class="mt-5">{{ $admins->links() }}</div>
    @endif
@endsection
