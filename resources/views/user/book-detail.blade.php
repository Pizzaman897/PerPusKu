@extends('layouts.user')

@section('title', $title)

@section('content')
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('user.dashboard') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke daftar buku</a>
        <article class="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="grid gap-8 sm:grid-cols-[240px_1fr]">
                <img src="{{ asset($book->url_sampul ?: 'images/buku-1.jpg') }}" alt="Sampul {{ $book->judul }}" class="mx-auto aspect-[3/4] w-48 rounded-xl object-cover shadow-md sm:w-full">
                <div class="flex flex-col">
                    <p class="text-sm font-semibold text-indigo-600">{{ ucfirst($book->kategori) }}</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $book->judul }}</h1>
                    <p class="mt-5 leading-7 text-slate-600">{{ $book->deskripsi }}</p>
                    @if ($peminjamanAktif === null)
                        <span class="mt-6 w-fit rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span>
                        <div class="mt-8">
                            <form method="POST" action="{{ route('user.book.pinjam', $book) }}">
                                @csrf
                                <button type="submit" class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Pinjam buku</button>
                            </form>
                        </div>
                    @else
                        <span class="mt-6 w-fit rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                            {{ $peminjamanAktif->statusEfektif() === 'pending' ? 'Menunggu persetujuan' : 'Sedang dipinjam' }}
                        </span>
                    @endif
                </div>
            </div>
        </article>
    </div>
@endsection
