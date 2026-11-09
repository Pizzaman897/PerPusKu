@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('admin.buku.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke daftar buku</a>
        <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="mb-7">
                <p class="text-sm font-semibold text-indigo-600">Koleksi perpustakaan</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Tambah buku</h1>
                <p class="mt-2 text-sm text-slate-500">Isi informasi buku yang akan ditambahkan ke koleksi.</p>
            </div>

            @if ($errors->any())
                <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.buku.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul buku</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Masukkan judul buku">
                </div>
                <div>
                    <label for="category" class="mb-2 block text-sm font-semibold text-slate-700">Kategori</label>
                    <select id="category" name="category" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                        <option value="" disabled @selected(old('category') === null)>Pilih kategori</option>
                        <option value="fiksi" @selected(old('category') === 'fiksi')>Fiksi</option>
                        <option value="non-fiksi" @selected(old('category') === 'non-fiksi')>Non-fiksi</option>
                        <option value="pelajaran" @selected(old('category') === 'pelajaran')>Pelajaran</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Ringkasan singkat buku">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label for="image_url" class="mb-2 block text-sm font-semibold text-slate-700">URL sampul</label>
                    <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="https://">
                </div>
                <p class="rounded-xl bg-indigo-50 px-4 py-3 text-sm text-indigo-800">Status awal buku otomatis <strong>tersedia</strong>. Status berubah saat buku dipinjam atau dikembalikan.</p>
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.buku.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Simpan data buku</button>
                </div>
            </form>
        </div>
    </div>
@endsection
