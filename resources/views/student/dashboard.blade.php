@extends('layouts.student')

@section('title', $title)

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-indigo-600">Perpustakaan digital sekolah</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Jelajahi Buku</h1>
            <p class="mt-2 text-sm text-slate-500">Temukan bacaan berikutnya dari koleksi perpustakaan.</p>
        </div>
        <label class="sr-only" for="category">Filter kategori</label>
        <select id="category" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-100">
            <option>Semua Kategori</option>
            <option>Pelajaran</option>
            <option>Fiksi</option>
            <option>Non-Fiksi</option>
        </select>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($books as $book)
            <a href="{{ route('student.book.show', $book['id']) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <img src="{{ $book['url gambar'] }}" alt="Sampul {{ $book['title'] }}" class="h-64 w-full object-cover">
                <div class="p-5">
                    <h2 class="mt-2 truncate text-lg font-bold text-slate-900 group-hover:text-indigo-700">{{ $book['title'] }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $book['source'] }}</p>
                    <div class="mt-4 flex items-center gap-2 text-sm font-medium text-slate-600">
                        <span class="size-2.5 rounded-full {{ $book['status'] === 'ada' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                        {{ $book['status'] === 'ada' ? 'Tersedia' : 'Dipinjam' }}
                    </div>
                </div>
            </a>
        @empty
            <p class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">Belum ada buku dalam koleksi.</p>
        @endforelse
    </div>
@endsection
