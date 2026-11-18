@extends('layouts.user')

@section('title', $title)

@section('content')
    <div class="mb-8">
        <p class="text-sm font-semibold text-indigo-600">Aktivitas Anda</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Peminjaman Saya</h1>
        <p class="mt-2 text-sm text-slate-500">Pantau status permintaan dan batas pengembalian buku.</p>
    </div>

    @if (session('success'))
        <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-5">
        @forelse ($peminjaman as $item)
            @php($status = $item->statusEfektif())
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-5 sm:flex-row">
                    <img src="{{ asset($item->buku->url_sampul ?: 'images/buku-1.jpg') }}" alt="Sampul {{ $item->buku->judul }}" class="h-48 w-36 rounded-xl object-cover shadow-sm">
                    <div class="flex flex-1 flex-col">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600">Buku</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-900">{{ $item->buku->judul }}</h2>
                            </div>
                            <span @class([
                                'w-fit rounded-full px-3 py-1 text-xs font-semibold',
                                'bg-slate-100 text-slate-700' => $status === 'pending',
                                'bg-emerald-50 text-emerald-700' => $status === 'dikembalikan',
                                'bg-red-50 text-red-700' => in_array($status, ['terlambat', 'lewat_batas_waktu'], true),
                                'bg-amber-50 text-amber-700' => $status === 'dipinjam',
                            ])>
                                {{ match ($status) {
                                    'pending' => 'Pending - menunggu persetujuan',
                                    'dipinjam' => 'Sedang dipinjam',
                                    'lewat_batas_waktu' => 'Lewat batas waktu',
                                    'dikembalikan' => 'Dikembalikan',
                                    'terlambat' => 'Terlambat',
                                    default => $status,
                                } }}
                            </span>
                        </div>
                        <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Tanggal peminjaman</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-800">{{ $item->dipinjam_pada->format('d-m-Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Batas pengembalian</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-800">{{ $item->batas_pengembalian?->format('d-m-Y H:i') ?? 'Belum diatur admin' }}</dd>
                            </div>
                            @if ($item->dikembalikan_pada)
                                <div>
                                    <dt class="text-xs font-medium text-slate-500">Tanggal dikembalikan</dt>
                                    <dd class="mt-1 text-sm font-semibold text-slate-800">{{ $item->dikembalikan_pada->format('d-m-Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                        @if (in_array($status, ['dipinjam', 'lewat_batas_waktu'], true))
                            <form method="POST" action="{{ route('user.book.kembalikan', $item) }}" class="mt-6">
                                @csrf
                                <button type="submit" class="w-fit rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Kembalikan buku</button>
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
