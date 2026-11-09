@extends('layouts.admin')

@section('title', 'Tambah Admin - PerPusKu')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('admin.kelola-admin.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke daftar admin</a>
        <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="mb-7">
                <p class="text-sm font-semibold text-indigo-600">Akses aplikasi</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Tambah admin</h1>
                <p class="mt-2 text-sm text-slate-500">Masukkan nama dan email akun admin baru.</p>
                <p class="mt-2 text-sm text-slate-500">Kata sandi dibuat otomatis dan hanya ditampilkan sekali setelah akun dibuat.</p>
            </div>
            @if ($errors->any())
                <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.kelola-admin.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama admin</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Nama lengkap">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="nama@email.com">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.kelola-admin.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">Tambahkan admin</button>
                </div>
            </form>
        </div>
    </div>
@endsection
