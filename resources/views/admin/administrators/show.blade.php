@extends('layouts.admin')

@section('title', 'Detail Admin - PerPusKu')

@section('content')
    <div class="mx-auto max-w-4xl">
        <a href="{{ route('admin.kelola-admin.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke daftar admin</a>
        <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-7 text-white sm:px-8">
                <p class="text-sm font-medium text-indigo-100">Profil admin</p>
                <h1 class="mt-1 text-2xl font-bold">{{ $admin->name }}</h1>
            </div>
            <dl class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">ID Admin</dt>
                    <dd class="mt-2 font-semibold text-slate-900">#{{ $admin->id }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama</dt>
                    <dd class="mt-2 font-semibold text-slate-900">{{ $admin->name }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</dt>
                    <dd class="mt-2 break-all font-semibold text-slate-900">{{ $admin->email }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4 sm:col-span-2">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Terdaftar sejak</dt>
                    <dd class="mt-2 font-semibold text-slate-900">{{ $admin->created_at?->translatedFormat('d F Y') ?? '-' }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4 sm:col-span-2">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Diperbarui pada</dt>
                    <dd class="mt-2 font-semibold text-slate-900">{{ $admin->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}</dd>
                </div>
            </dl>
            <div class="flex justify-end border-t border-slate-100 px-6 py-5 sm:px-8">
                <a href="{{ route('admin.kelola-admin.edit', $admin) }}" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">Edit admin</a>
            </div>
        </section>
    </div>
@endsection
