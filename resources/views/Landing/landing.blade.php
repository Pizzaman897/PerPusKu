<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerPusKu - Perpustakaan Digital Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', 'Segoe UI', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800">

    {{-- ================= NAVBAR ================= --}}
    <header class="bg-[#E9EDFB]">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-5">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg text-gray-900">
                <img src="{{ asset('images/logo-perpusku.png') }}" alt="Logo PerPusKu" class="h-8 w-auto">
                <span>PerPusKu</span>
            </a>

            <ul class="hidden md:flex items-center gap-10 font-medium text-gray-800">
                <li><a href="#beranda" class="hover:text-indigo-600">Beranda</a></li>
                <li><a href="#tentang" class="hover:text-indigo-600">Tentang</a></li>
                <li><a href="#kontak" class="hover:text-indigo-600">Kontak</a></li>
            </ul>

            <div class="flex items-center gap-3">
                <a href="{{ url('/login') }}"
                   class="px-5 py-2 rounded-lg border border-indigo-600 text-indigo-600 font-medium hover:bg-indigo-50">
                    Masuk
                </a>
                <a href="{{ url('/register') }}"
                   class="px-5 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700">
                    Daftar
                </a>
            </div>
        </nav>

        {{-- ================= HERO ================= --}}
        <div id="beranda" class="max-w-7xl mx-auto grid md:grid-cols-2 items-center gap-10 px-6 py-14">
            <div>
                <h1 class="text-5xl font-extrabold text-gray-900 mb-3">PerPusKu</h1>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Perpustakaan digital sekolah</h2>
                <p class="text-gray-600 mb-6 max-w-md">
                    Meminjam dan mengelola buku jadi lebih mudah, cepat, dan teratur
                </p>
                <a href="#tentang"
                   class="inline-block px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                    Jelajahi Buku
                </a>
            </div>

            <div class="flex justify-center">
                <img src="{{ asset('images/ilustrasi-baca-buku.png') }}"
                     alt="Ilustrasi siswa membaca buku"
                     class="w-full max-w-md">
            </div>
        </div>
    </header>

    {{-- ================= SOCIAL + FEATURES ================= --}}
    <section class="max-w-7xl mx-auto px-6 py-16">

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $features = [
                    ['icon' => 'icon-book.png', 'title' => 'Koleksi Lengkap', 'desc' => 'Ribuan buku tersedia dari berbagai katagori'],
                    ['icon' => 'icon-bookmark.png', 'title' => 'Peminjaman Mudah', 'desc' => 'Pinjam buku hanya dalam beberapa detik'],
                    ['icon' => 'icon-history.png', 'title' => 'Riwayat Tersimpan', 'desc' => 'Ribuan buku tersedia dari berbagai katagori'],
                    ['icon' => 'icon-shield.png', 'title' => 'Aman & Terpercaya', 'desc' => 'Ribuan buku tersedia dari berbagai katagori'],
                ];
            @endphp

            @foreach ($features as $f)
                <div class="bg-[#F5F6FC] rounded-2xl p-8 text-center shadow-sm">
                    <img src="{{ asset('images/' . $f['icon']) }}" alt="{{ $f['title'] }}" class="w-10 h-10 mx-auto mb-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================= CTA BANNER ================= --}}
    <section class="max-w-7xl mx-auto px-6 pb-16">
        <div class="bg-[#0B1550] rounded-2xl px-10 py-10 flex flex-col md:flex-row items-center gap-8">
            <img src="{{ asset('images/book-icon.png') }}" alt="Buku" class="w-30 h-30">
            <div>
                <h3 class="text-white text-2xl font-bold mb-4">
                    Mari membaca, menambah ilmu,<br class="hidden md:block"> dan menginspirasi dunia!
                </h3>
                <a href="#tentang"
                   class="inline-block px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                    Jelajahi Buku
                </a>
            </div>
        </div>
    </section>

    {{-- ================= TENTANG KAMI ================= --}}
    <section id="tentang" class="bg-[#EFF1FB] py-20">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 items-center px-6">
            <div class="relative flex items-center justify-center">
                <div class="absolute w-56 h-56 bg-indigo-200 rounded-full opacity-60 -z-10"></div>
                <div class="absolute w-16 h-16 bg-indigo-300 rounded-full opacity-60 -translate-x-24 translate-y-16 -z-10"></div>
                <h2 class="text-5xl font-extrabold text-indigo-700 leading-tight">
                    Tentang<br>kami
                </h2>
            </div>
            <div>
                <p class="text-indigo-900 font-medium leading-relaxed">
                    PERPUSKU adalah platform perpustakaan digital yang dirancang untuk memberikan pengalaman
                    membaca dan peminjaman buku yang lebih mudah, cepat, dan terorganisir bagi siswa.
                    Melalui PERPUSKU, siswa dapat mencari koleksi buku, melihat informasi dan ketersediaan
                    buku, melakukan peminjaman, serta memantau riwayat peminjaman dengan lebih praktis.
                    Kami juga membantu petugas perpustakaan dalam mengelola data buku dan transaksi
                    peminjaman secara digital, sehingga pengelolaan perpustakaan menjadi lebih efisien.
                    Dengan hadirnya PERPUSKU, kami berharap dapat meningkatkan minat membaca dan
                    menciptakan lingkungan sekolah yang lebih dekat dengan literasi dan pengetahuan.
                </p>
            </div>
        </div>
    </section>

    {{-- ================= KONTAK ================= --}}
    <section id="kontak" class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/contact-illustration.png') }}" alt="Ilustrasi hubungi kami" class="w-full max-w-md">
        </div>

        <div>
            <h2 class="text-4xl font-extrabold text-indigo-700 mb-8">Hubungi kami</h2>

            <form action="{{ url('/contact') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Nama lengkap"
                       class="w-full px-5 py-3 rounded-lg bg-[#F5F6FC] focus:outline-none focus:ring-2 focus:ring-indigo-400">

                <input type="email" name="email" placeholder="Email"
                       class="w-full px-5 py-3 rounded-lg bg-[#F5F6FC] focus:outline-none focus:ring-2 focus:ring-indigo-400">

                <textarea name="message" rows="5" placeholder="Ada yang mau kamu ceritain?"
                          class="w-full px-5 py-3 rounded-lg bg-[#F5F6FC] focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>

                <button type="submit"
                        class="px-8 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                    Kirim
                </button>
            </form>
        </div>
    </section>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-[#2B2FE0] text-white pt-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 pb-10">
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg mb-4">
                    <img src="{{ asset('images/logo-perpusku.png') }}" alt="Logo PerPusKu" class="h-8 w-auto">
                    <span>PerPusKu</span>
                </a>
                <p class="text-indigo-100 max-w-sm mb-4">
                    Misi kami adalah menghadirkan akses perpustakaan yang lebih mudah, membantu siswa
                    menemukan buku yang mereka butuhkan, dan menumbuhkan budaya membaca di lingkungan sekolah.
                </p>
                <div class="flex gap-4">
                    <a href="#"><img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-7 h-7"></a>
                    <a href="#"><img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-7 h-7"></a>
                </div>
            </div>

            <div class="flex md:justify-end">
                <ul class="space-y-3 font-semibold text-lg">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-indigo-400/40">
            <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row justify-between items-center text-sm text-indigo-100 gap-2">
                <span>{{ date('Y') }}@ perpusku. All Rights Reserved</span>
                <div class="flex gap-6">
                    <a href="#" class="underline">Privacy-Policy</a>
                    <a href="#" class="underline">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>