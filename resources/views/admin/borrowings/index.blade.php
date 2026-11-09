@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="mb-8">
        <p class="text-sm font-semibold text-indigo-600">Aktivitas perpustakaan</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Status Peminjaman</h1>
        <p class="mt-2 text-sm text-slate-500">Pantau buku yang sedang dipinjam dan riwayat pengembaliannya.</p>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1280px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold">ID Pinjam</th>
                        <th class="px-5 py-4 font-semibold">ID Murid</th>
                        <th class="px-5 py-4 font-semibold">Murid</th>
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
                        <tr class="hover:bg-slate-50/70">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $borrowing['id'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $borrowing['student_id'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">{{ $borrowing['student'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">#{{ $borrowing['book_id'] }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $borrowing['book_title'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing['borrowed_at'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing['due_at'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing['returned_at'] ?: 'Belum dikembalikan' }}</td>
                            <td class="px-5 py-4">
                                @if ($borrowing['status'] === 'dikembalikan')
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Dikembalikan</span>
                                @elseif ($borrowing['status'] === 'terlambat')
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">Terlambat</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Dipinjam</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing['created_at'] }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $borrowing['updated_at'] }}</td>
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
