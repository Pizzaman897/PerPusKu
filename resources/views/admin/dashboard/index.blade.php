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
            <p class="text-sm font-medium text-slate-500">Total user</p>
            <p class="mt-4 text-4xl font-bold text-slate-900">{{ $totalUsers }}</p>
            <a href="{{ route('admin.users.index') }}" class="mt-5 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-800">Kelola user →</a>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total admin</p>
            <p class="mt-4 text-4xl font-bold text-slate-900">{{ $totalAdmin }}</p>
            <a href="{{ route('admin.kelola-admin.index') }}" class="mt-5 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-800">Kelola admin →</a>
        </article>
    </section>
@endsection
