@extends('layouts.student')

@section('title', $title)

@section('content')
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('student.dashboard') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke daftar buku</a>
        <article class="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="grid gap-8 sm:grid-cols-[240px_1fr]">
                <img src="{{ $book['url gambar'] }}" alt="Sampul {{ $book['title'] }}" class="mx-auto aspect-[3/4] w-48 rounded-xl object-cover shadow-md sm:w-full">
                <div class="flex flex-col">
                    <p class="text-sm font-semibold text-indigo-600">{{ $book['category'] }}</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $book['title'] }}</h1>
                    <p class="mt-5 leading-7 text-slate-600">{{ $book['description'] }}</p>
                    <span @class(['mt-6 w-fit rounded-full px-3 py-1 text-xs font-semibold', 'bg-emerald-50 text-emerald-700' => $book['status'] === 'ada', 'bg-red-50 text-red-700' => $book['status'] !== 'ada'])>
                        {{ $book['status'] === 'ada' ? 'Tersedia' : 'Dipinjam' }}
                    </span>
                    <div class="mt-8">
                        @if ($book['status'] === 'ada')
                            <form method="POST" action="{{ route('student.book.pinjam', $book['id']) }}">
                                @csrf
                                <button type="submit" class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Pinjam buku</button>
                            </form>
                        @else
                            <button type="button" disabled class="cursor-not-allowed rounded-xl bg-slate-300 px-6 py-3 text-sm font-semibold text-white">Pinjam buku</button>
                        @endif
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection
