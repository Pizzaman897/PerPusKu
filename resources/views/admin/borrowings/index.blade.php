@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="mb-8">
        <p class="text-sm font-semibold text-indigo-600">Aktivitas perpustakaan</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Status Peminjaman</h1>
        <p class="mt-2 text-sm text-slate-500">Atur batas pengembalian selama status masih Pending. Setelah disetujui, status dan batas tidak dapat diubah.</p>
    </div>

    @if ($errors->any())
        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1500px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold">ID Pinjam</th>
                        <th class="px-5 py-4 font-semibold">ID User</th>
                        <th class="px-5 py-4 font-semibold">User</th>
                        <th class="px-5 py-4 font-semibold">ID Buku</th>
                        <th class="px-5 py-4 font-semibold">Judul buku</th>
                        <th class="px-5 py-4 font-semibold">Tanggal pinjam</th>
                        <th class="px-5 py-4 font-semibold">Batas kembali</th>
                        <th class="px-5 py-4 font-semibold">Tanggal kembali</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold">Dibuat pada</th>
                        <th class="px-5 py-4 font-semibold">Diperbarui pada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($borrowings as $borrowing)
                        @php($status = $borrowing->statusEfektif())
                        <tr class="align-top hover:bg-slate-50/70">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $borrowing->id }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $borrowing->user_id }}</td>
                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">{{ $borrowing->user->name }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $borrowing->buku_id }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $borrowing->buku->judul }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing->dipinjam_pada->format('d-m-Y H:i') }}</td>
                            <td class="min-w-64 px-5 py-4">
                                @if ($borrowing->status === 'pending')
                                    <form method="POST" action="{{ route('admin.status.update', $borrowing) }}" class="flex flex-col gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input
                                            type="datetime-local"
                                            name="batas_pengembalian"
                                            value="{{ old('batas_pengembalian', $borrowing->batas_pengembalian?->format('Y-m-d\TH:i')) }}"
                                            min="{{ now()->format('Y-m-d\TH:i') }}"
                                            required
                                            class="rounded-lg border border-slate-300 px-2 py-2 text-xs text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                                        >
                                        <button type="submit" class="w-fit text-xs font-semibold text-indigo-600 hover:text-indigo-800">Simpan batas</button>
                                    </form>
                                @else
                                    <span class="whitespace-nowrap text-slate-600">{{ $borrowing->batas_pengembalian?->format('d-m-Y H:i') ?? 'Belum diatur' }}</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing->dikembalikan_pada?->format('d-m-Y H:i') ?? 'Belum dikembalikan' }}</td>
                            <td class="min-w-56 px-5 py-4">
                                <span @class([
                                    'mb-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-slate-100 text-slate-700' => $status === 'pending',
                                    'bg-emerald-50 text-emerald-700' => $status === 'dikembalikan',
                                    'bg-red-50 text-red-700' => in_array($status, ['terlambat', 'lewat_batas_waktu'], true),
                                    'bg-amber-50 text-amber-700' => $status === 'dipinjam',
                                ])>
                                    {{ match ($status) {
                                        'pending' => 'Pending',
                                        'dipinjam' => 'Sedang dipinjam',
                                        'lewat_batas_waktu' => 'Lewat batas waktu',
                                        'dikembalikan' => 'Dikembalikan',
                                        'terlambat' => 'Terlambat',
                                        default => $status,
                                    } }}
                                </span>
                                @if ($borrowing->status === 'pending')
                                    <form method="POST" action="{{ route('admin.status.update', $borrowing) }}" class="flex flex-col gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" required class="rounded-lg border border-slate-300 px-2 py-2 text-xs text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                                            <option value="pending" @selected($borrowing->status === 'pending')>Pending</option>
                                            <option value="dipinjam" @selected($borrowing->status === 'dipinjam')>Sedang dipinjam</option>
                                        </select>
                                        <button type="submit" class="w-fit text-xs font-semibold text-indigo-600 hover:text-indigo-800">Simpan status</button>
                                    </form>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing->created_at->format('d-m-Y H:i') }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-5 py-12 text-center text-slate-500">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
