<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PERPUSKU</title>
    {{-- Ganti dengan @vite(['resources/css/app.css']) kalau sudah pakai Tailwind lewat Vite --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl overflow-hidden grid md:grid-cols-2">

        {{-- PANEL KIRI --}}
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white p-10 flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-white/15 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">PERPUSKU</h1>
                <p class="text-indigo-100 mt-1">Selamat Datang Kembali!</p>
                <p class="text-indigo-200 text-sm mt-4 leading-relaxed">
                    Kelola peminjaman buku, cek koleksi, dan pantau riwayat perpustakaan kamu di satu tempat.
                </p>
            </div>

            <div class="mt-10 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 140" class="w-48 h-auto opacity-90">
                    <rect x="20" y="90" width="160" height="14" rx="3" fill="#ffffff" fill-opacity="0.9"/>
                    <rect x="35" y="70" width="60" height="20" rx="3" fill="#c7d2fe"/>
                    <rect x="105" y="60" width="60" height="30" rx="3" fill="#a5b4fc"/>
                    <path d="M60 55 L100 40 L140 55 L140 65 L100 50 L60 65 Z" fill="#ffffff"/>
                    <circle cx="100" cy="25" r="12" fill="#fbbf24"/>
                </svg>
            </div>
        </div>

        {{-- PANEL KANAN --}}
        <div class="p-10 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-slate-800 mb-1">Masuk ke akun Anda</h2>
            <p class="text-sm text-slate-500 mb-6">Silakan masukkan email dan kata sandi Anda</p>

            {{-- Notifikasi status (misal setelah reset password) --}}
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="nama@email.com"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-400 @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-400 @enderror"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ingat saya + lupa password --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        Ingat saya
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>

                {{-- Tombol masuk --}}
                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors"
                >
                    Masuk
                </button>
            </form>

            @if (Route::has('register'))
                <p class="text-center text-sm text-slate-500 mt-6">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Daftar</a>
                </p>
            @endif
        </div>
    </div>

</body>
</html>