<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'PerPusKu | Murid')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <header class="flex h-18 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-8">
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-perpusku.png') }}" alt="" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight text-[#142654]">PerPusKu</span>
            </a>

            <div class="flex items-center gap-3">
                <span class="hidden text-sm font-medium text-slate-600 sm:block">Halo, {{ auth()->user()->name ?? 'Murid' }}</span>
                <span class="grid size-10 place-items-center rounded-full bg-indigo-100 font-bold text-indigo-700">
                    {{ mb_substr(auth()->user()->name ?? 'M', 0, 1) }}
                </span>
            </div>
        </header>

        <nav aria-label="Navigasi murid" class="flex gap-2 overflow-x-auto border-b border-slate-200 bg-white px-3 py-2 lg:hidden">
            <a href="{{ route('student.dashboard') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('student.dashboard') || request()->routeIs('student.book.show'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('student.dashboard') && ! request()->routeIs('student.book.show')])>Beranda</a>
            <a href="{{ route('student.status') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('student.status'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('student.status')])>Peminjaman</a>
            <a href="{{ route('student.history') }}" @class(['shrink-0 rounded-lg px-3 py-2 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('student.history'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('student.history')])>Riwayat</a>
            <form action="{{ route('student.logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Keluar</button>
            </form>
        </nav>

        <div class="mx-auto flex min-h-[calc(100vh-4.5rem)] max-w-[1600px]">
            <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white px-4 py-6 lg:block">
                <p class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu utama</p>
                <nav aria-label="Navigasi murid" class="flex flex-col gap-1">
                    <a href="{{ route('student.dashboard') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('student.dashboard') || request()->routeIs('student.book.show'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('student.dashboard') && ! request()->routeIs('student.book.show')])>Beranda</a>
                    <a href="{{ route('student.status') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('student.status'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('student.status')])>Peminjaman</a>
                    <a href="{{ route('student.history') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-medium', 'bg-indigo-600 text-white' => request()->routeIs('student.history'), 'text-slate-600 hover:bg-slate-100' => ! request()->routeIs('student.history')])>Riwayat</a>
                </nav>

                <form action="{{ route('student.logout') }}" method="POST" class="mt-6 border-t border-slate-100 pt-4">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-medium text-slate-600 hover:bg-slate-100">Keluar</button>
                </form>
            </aside>

            <main class="min-w-0 flex-1 p-4 sm:p-8 lg:p-10">
                @yield('content')
            </main>
        </div>
    </body>
</html>
