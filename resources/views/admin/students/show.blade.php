@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="mx-auto max-w-4xl">
        <a href="{{ route('admin.murid.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke daftar murid</a>
        <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-7 text-white sm:px-8">
                <p class="text-sm font-medium text-indigo-100">Profil murid</p>
                <h1 class="mt-1 text-2xl font-bold">{{ $student['name'] }}</h1>
                <p class="mt-2 text-sm text-indigo-100">NIS {{ $student['nis'] }}</p>
            </div>
            <dl class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama lengkap</dt>
                    <dd class="mt-2 font-semibold text-slate-900">{{ $student['name'] }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</dt>
                    <dd class="mt-2 break-all font-semibold text-slate-900">{{ $student['email'] }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nomor Induk Siswa</dt>
                    <dd class="mt-2 font-semibold text-slate-900">{{ $student['nis'] }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">ID Murid</dt>
                    <dd class="mt-2 font-semibold text-slate-900">#{{ $student['id'] }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dibuat pada</dt>
                    <dd class="mt-2 font-semibold text-slate-900">{{ \Illuminate\Support\Carbon::parse($student['created_at'])->translatedFormat('d M Y, H:i') }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Diperbarui pada</dt>
                    <dd class="mt-2 font-semibold text-slate-900">{{ \Illuminate\Support\Carbon::parse($student['updated_at'])->translatedFormat('d M Y, H:i') }}</dd>
                </div>
            </dl>
            <div class="flex justify-end border-t border-slate-100 px-6 py-5 sm:px-8">
                <a href="{{ route('admin.murid.edit', $student['id']) }}" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Edit data murid</a>
            </div>
        </section>
    </div>
@endsection
