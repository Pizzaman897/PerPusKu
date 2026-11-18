@extends('layouts.user')

@section('title', $title)

@section('content')
    <div class="mb-8">
        <p class="text-sm font-semibold text-indigo-600">Aktivitas Anda</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Riwayat Peminjaman</h1>
        <p class="mt-2 text-sm text-slate-500">Buku yang sudah dikembalikan dan waktu pengembaliannya.</p>
    </div>

    <div class="space-y-5">
        @forelse ($riwayat as $item)
            @php($status = $item->statusEfektif())
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-5 sm:flex-row">
                    <img src="{{ asset($item->buku->url_sampul ?: 'images/buku-1.jpg') }}" alt="Sampul {{ $item->buku->judul }}" class="h-48 w-36 rounded-xl object-cover shadow-sm">
                    <div class="flex-1">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600">Buku</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-900">{{ $item->buku->judul }}</h2>
                            </div>
                            <span @class(['w-fit rounded-full px-3 py-1 text-xs font-semibold', 'bg-emerald-50 text-emerald-700' => $status === 'dikembalikan', 'bg-red-50 text-red-700' => $status === 'terlambat'])>
                                {{ $status === 'dikembalikan' ? 'Dikembalikan' : 'Terlambat' }}
                            </span>
                        </div>
                        <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Tanggal peminjaman</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-800">{{ $item->dipinjam_pada->format('d-m-Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Tanggal dikembalikan</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-800">{{ $item->dikembalikan_pada->format('d-m-Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">Belum ada riwayat peminjaman.</div>
        @endforelse
    </div>
@endsection
