<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PERPUSKU</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#eef0fb] min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">

        {{-- KIRI: Logo & Ilustrasi --}}
        <div class="flex flex-col items-center justify-center text-center p-10 border-b md:border-b-0 md:border-r border-gray-200">
            <img src="{{ asset('images/logo-perpusku.png') }}" alt="Logo Perpusku" class="w-28 h-28 object-contain mb-4">

            <h1 class="text-2xl font-bold text-gray-900">PERPUSKU</h1>
            <p class="text-gray-800 font-medium mt-2 mb-8">Selamat Datang Kembali!</p>

            <img src="{{ asset('images/ilustrasi-buku.png') }}" alt="Ilustrasi Buku" class="w-48 object-contain">
        </div>

        {{-- KANAN: Form Login --}}
        <div class="p-10 flex flex-col justify-center">
            <h2 class="text-lg font-bold text-gray-900 mb-6 text-center">Masuk ke akun Anda</h2>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="GET" action="{{ route('landing') }}" class="space-y-4">

                {{-- Username --}}
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <input type="text" name="username" value="{{ old('username') }}"
                        placeholder="Username"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                        required autofocus>
                </div>

                {{-- Password --}}
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" />
                        </svg>
                    </span>
                    <input type="password" name="password"
                        placeholder="Password"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                        required>
                </div>

                {{-- Ingat saya & Lupa password --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-gray-500">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Ingat saya
                    </label>
                    <a href="{{ Route::has('password.request') ? route('password.request') : '#' }}" class="text-indigo-600 font-medium hover:underline">Lupa Password?</a>
                </div>

                {{-- Tombol Masuk --}}
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
                    Masuk
                </button>

                {{-- Link Daftar --}}
                <p class="text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a href="{{ Route::has('register') ? route('register') : '#' }}" class="text-gray-900 font-semibold hover:underline">Daftar disini!</a>
                </p>
            </form>
        </div>

    </div>

</body>
</html>