@extends('layouts.user')

@section('title', $title)

@section('content')
    <div class="mb-8">
        <p class="text-sm font-semibold text-indigo-600">Aktivitas Anda</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Peminjaman Saya</h1>
        <p class="mt-2 text-sm text-slate-500">Pantau buku yang sedang dipinjam dan batas pengembaliannya.</p>
    </div>

    <div class="space-y-5">
        @forelse ($peminjaman as $item)
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-5 sm:flex-row">
                    <img src="{{ $item['url gambar'] }}" alt="Sampul {{ $item['judul_buku'] }}" class="h-48 w-36 rounded-xl object-cover shadow-sm">
                    <div class="flex flex-1 flex-col">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600">Buku</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-900">{{ $item['judul_buku'] }}</h2>
                            </div>
                            <span @class(['w-fit rounded-full px-3 py-1 text-xs font-semibold', 'bg-emerald-50 text-emerald-700' => $item['status'] === 'meminjam', 'bg-slate-100 text-slate-600' => $item['status'] !== 'meminjam'])>
                                {{ $item['status'] === 'meminjam' ? 'Meminjam' : 'Dikembalikan' }}
                            </span>
                        </div>
                        <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Tanggal peminjaman</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-800">{{ $item['tanggal_pinjam'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Batas pengembalian</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-800">{{ $item['batas_kembali'] }}</dd>
                            </div>
                        </dl>
                        @if ($item['status'] === 'meminjam')
                            <form method="POST" action="{{ route('user.book.kembalikan', $item['id']) }}" class="mt-6">
                                @csrf
                                <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Kembalikan buku</button>
                            </form>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">Kamu belum meminjam buku apa pun.</div>
        @endforelse
    </div>
@endsection
