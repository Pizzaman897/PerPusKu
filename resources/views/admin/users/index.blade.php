@extends('layouts.admin')

@section('title', $title)

@section('content')
    @if (session('success'))
        <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-indigo-600">Data perpustakaan</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Kelola User</h1>
            <p class="mt-2 text-sm text-slate-500">Lihat dan kelola informasi user perpustakaan.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
            Tambah user
        </a>
    </div>

    <section class="mb-6 rounded-2xl border border-indigo-100 bg-gradient-to-r from-indigo-50 to-white p-5 sm:p-6">
        <p class="text-sm font-medium text-indigo-700">Total user terdaftar</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $users->count() }}</p>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-semibold text-slate-900">Daftar user</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold">ID</th>
                        <th class="px-5 py-4 font-semibold">Nama</th>
                        <th class="px-5 py-4 font-semibold">Email</th>
                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/70">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $user->id }}</td>
                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-indigo-600 hover:text-indigo-800">Detail</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-slate-600 hover:text-indigo-700">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-500">Belum ada data user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
