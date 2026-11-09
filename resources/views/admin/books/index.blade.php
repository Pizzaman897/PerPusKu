@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-indigo-600">Koleksi perpustakaan</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Kelola Buku</h1>
            <p class="mt-2 text-sm text-slate-500">Tinjau koleksi buku yang tersedia di perpustakaan.</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">Tambah buku</a>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-semibold text-slate-900">Daftar buku</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold">ID</th>
                        <th class="px-5 py-4 font-semibold">Judul</th>
                        <th class="px-5 py-4 font-semibold">Kategori</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($books as $book)
                        <tr class="hover:bg-slate-50/70">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $book['id'] }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($book['image_url']) }}" alt="" class="h-14 w-11 rounded-lg object-cover ring-1 ring-slate-200">
                                    <div>
                                        <a href="{{ route('admin.buku.show', $book['id']) }}" class="font-semibold text-slate-800 hover:text-indigo-700">{{ $book['title'] }}</a>
                                        <p class="mt-1 max-w-md truncate text-xs text-slate-500">{{ $book['description'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ ucfirst($book['category']) }}</td>
                            <td class="px-5 py-4">
                                @if ($book['status'] === 'tersedia')
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Dipinjam</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.buku.show', $book['id']) }}" class="font-medium text-indigo-600 hover:text-indigo-800">Detail</a>
                                    <a href="{{ route('admin.buku.edit', $book['id']) }}" class="font-medium text-slate-600 hover:text-indigo-700">Edit</a>
                                    <form action="{{ route('admin.buku.destroy', $book['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
