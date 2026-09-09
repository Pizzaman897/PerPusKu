<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900">
        <main class="mx-auto max-w-5xl px-6 py-10">
            <h1 class="text-3xl font-bold">Status Peminjaman</h1>
            <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-slate-50"><tr><th class="p-4">Peminjam</th><th class="p-4">Buku</th><th class="p-4">Tanggal</th><th class="p-4">Status</th></tr></thead><tbody>
                    @foreach ($borrowings as $borrowing)
                        <tr class="border-t border-slate-100"><td class="p-4">{{ $borrowing['name'] }}</td><td class="p-4">{{ $borrowing['book'] }}</td><td class="p-4">{{ $borrowing['borrow_date'] }} - {{ $borrowing['return_date'] }}</td><td class="p-4 font-medium text-amber-600">{{ $borrowing['status'] }}</td></tr>
                    @endforeach
                </tbody></table></div>
            </div>
        </main>
    </body>
</html>
