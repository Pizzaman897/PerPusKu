@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-indigo-600">Data perpustakaan</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Kelola Murid</h1>
            <p class="mt-2 text-sm text-slate-500">Lihat dan kelola informasi anggota perpustakaan.</p>
        </div>
        <a href="{{ route('admin.murid.create') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
            Tambah murid
        </a>
    </div>

    <section class="mb-6 rounded-2xl border border-indigo-100 bg-gradient-to-r from-indigo-50 to-white p-5 sm:p-6">
        <p class="text-sm font-medium text-indigo-700">Total murid terdaftar</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ count($students) }}</p>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-semibold text-slate-900">Daftar murid</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold">ID</th>
                        <th class="px-5 py-4 font-semibold">Nama</th>
                        <th class="px-5 py-4 font-semibold">Email</th>
                        <th class="px-5 py-4 font-semibold">NIS</th>
                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($students as $student)
                        <tr class="hover:bg-slate-50/70">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $student['id'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">{{ $student['name'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $student['email'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $student['nis'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.murid.show', $student['id']) }}" class="font-medium text-indigo-600 hover:text-indigo-800">Detail</a>
                                    <a href="{{ route('admin.murid.edit', $student['id']) }}" class="font-medium text-slate-600 hover:text-indigo-700">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">Belum ada data murid.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
