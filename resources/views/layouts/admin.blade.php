<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'PerPusKu | Admin')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <header class="flex h-18 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-8">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-perpusku.png') }}" alt="" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight text-[#142654]">PerPusKu</span>
            </a>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-xs text-slate-500">Masuk sebagai</p>
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                </div>
                <span class="grid size-10 place-items-center rounded-full bg-indigo-100 font-bold text-indigo-700">
                    {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
                </span>
            </div>
        </header>

        <nav aria-label="Navigasi admin" class="flex gap-2 overflow-x-auto border-b border-slate-200 bg-white px-3 py-2 lg:hidden">
            <a href="{{ route('admin.dashboard') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.dashboard'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.dashboard')])>Dasbor</a>
            <a href="{{ route('admin.buku.index') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.buku.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.buku.*')])>Buku</a>
            <a href="{{ route('admin.status.index') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.status.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.status.*')])>Peminjaman</a>
            <a href="{{ route('admin.kelola-admin.index') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.kelola-admin.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.kelola-admin.*')])>Admin</a>
            <a href="{{ route('admin.users.index') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.users.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.users.*')])>User</a>
        </nav>

        <div class="mx-auto flex min-h-[calc(100vh-4.5rem)] max-w-[1600px]">
            <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white px-4 py-6 lg:flex lg:flex-col">
                <p class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu utama</p>
                <nav aria-label="Navigasi admin" class="flex flex-col gap-1">
                    <a href="{{ route('admin.dashboard') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.dashboard'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.dashboard')])>Dasbor</a>
                    <a href="{{ route('admin.buku.index') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.buku.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.buku.*')])>Kelola Buku</a>
                    <a href="{{ route('admin.status.index') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.status.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.status.*')])>Peminjaman</a>
                    <a href="{{ route('admin.kelola-admin.index') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.kelola-admin.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.kelola-admin.*')])>Kelola Admin</a>
                    <a href="{{ route('admin.users.index') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('admin.users.*'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('admin.users.*')])>Kelola User</a>
                </nav>

                <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto border-t border-slate-100 pt-4">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-medium text-slate-600 hover:bg-slate-100">Keluar</button>
                </form>
            </aside>

            <main class="min-w-0 flex-1 p-4 sm:p-8 lg:p-10">
                @if (session('success'))
                    <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>
