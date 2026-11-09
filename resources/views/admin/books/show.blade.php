@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="mx-auto max-w-4xl">
        <a href="{{ route('admin.buku.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke daftar buku</a>
        <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="grid gap-7 p-6 sm:grid-cols-[200px_1fr] sm:p-8">
                <img src="{{ asset($book['image_url']) }}" alt="Sampul {{ $book['title'] }}" class="mx-auto aspect-[3/4] w-40 rounded-xl object-cover shadow-md sm:w-full">
                <div class="flex flex-col">
                    <div class="flex flex-wrap items-center gap-3">
                        <p class="text-sm font-semibold text-indigo-600">{{ ucfirst($book['category']) }}</p>
                        @if ($book['status'] === 'tersedia')
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span>
                        @else
                            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Dipinjam</span>
                        @endif
                    </div>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">{{ $book['title'] }}</h1>
                    <p class="mt-5 leading-7 text-slate-600">{{ $book['description'] }}</p>
                    <dl class="mt-6 grid gap-4 border-t border-slate-100 pt-5 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">ID Buku</dt>
                            <dd class="mt-1 font-semibold text-slate-800">#{{ $book['id'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kategori</dt>
                            <dd class="mt-1 font-semibold text-slate-800">{{ ucfirst($book['category']) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dibuat pada</dt>
                            <dd class="mt-1 font-semibold text-slate-800">{{ \Illuminate\Support\Carbon::parse($book['created_at'])->translatedFormat('d M Y, H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Diperbarui pada</dt>
                            <dd class="mt-1 font-semibold text-slate-800">{{ \Illuminate\Support\Carbon::parse($book['updated_at'])->translatedFormat('d M Y, H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="flex justify-end border-t border-slate-100 px-6 py-5 sm:px-8">
                <a href="{{ route('admin.buku.edit', $book['id']) }}" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Edit data buku</a>
            </div>
        </section>
    </div>
@endsection
