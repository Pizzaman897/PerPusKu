@extends('layouts.admin')

@section('title', 'Dasbor Admin - PerPusKu')

@section('content')
    <div class="mb-8">
        <p class="text-sm font-semibold text-indigo-600">Ringkasan perpustakaan</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Dasbor Admin</h1>
        <p class="mt-2 text-sm text-slate-500">Pantau kondisi koleksi dan aktivitas perpustakaan.</p>
    </div>

    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total buku</p>
            <p class="mt-4 text-4xl font-bold text-slate-900">{{ $totalBuku }}</p>
            <a href="{{ route('admin.buku.index') }}" class="mt-5 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-800">Lihat koleksi →</a>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total murid</p>
            <p class="mt-4 text-4xl font-bold text-slate-900">{{ $totalMurid }}</p>
            <a href="{{ route('admin.murid.index') }}" class="mt-5 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-800">Kelola murid →</a>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Buku sedang dipinjam</p>
            <p class="mt-4 text-4xl font-bold text-slate-900">{{ $bukuDipinjam }}</p>
            <a href="{{ route('admin.status.index') }}" class="mt-5 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-800">Lihat peminjaman →</a>
        </article>
    </section>
@endsection
