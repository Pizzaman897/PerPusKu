@extends('layouts.user')

@section('title', $title)

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-indigo-600">Perpustakaan digital</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Jelajahi Buku</h1>
            <p class="mt-2 text-sm text-slate-500">Temukan bacaan berikutnya dari koleksi perpustakaan.</p>
        </div>
        <form method="GET" action="{{ route('user.dashboard') }}" class="flex w-full gap-2 sm:w-auto">
            <label class="sr-only" for="category">Filter kategori</label>
            <select id="category" name="category" class="min-w-0 flex-1 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-100 sm:flex-none">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Filter</button>
        </form>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($books as $book)
            <a href="{{ route('user.book.show', $book) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <img src="{{ asset($book->url_sampul ?: 'images/buku-1.jpg') }}" alt="Sampul {{ $book->judul }}" class="h-64 w-full object-cover">
                <div class="p-5">
                    <h2 class="mt-2 truncate text-lg font-bold text-slate-900 group-hover:text-indigo-700">{{ $book->judul }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ ucfirst($book->kategori) }}</p>
                    <div class="mt-4 flex items-center gap-2 text-sm font-medium text-slate-600">
                        <span class="size-2.5 rounded-full {{ $book->sedang_dipinjam ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                        {{ $book->sedang_dipinjam ? 'Tidak tersedia' : 'Tersedia' }}
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">
                <p>{{ $selectedCategory ? 'Belum ada buku dalam kategori ini.' : 'Belum ada buku dalam koleksi.' }}</p>
                @if ($selectedCategory)
                    <a href="{{ route('user.dashboard') }}" class="mt-2 inline-block font-semibold text-indigo-600 hover:text-indigo-800">Tampilkan semua buku</a>
                @endif
            </div>
        @endforelse
    </div>
@endsection
