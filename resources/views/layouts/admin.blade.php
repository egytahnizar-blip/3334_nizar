<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    <aside class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <span class="text-xl font-bold text-white tracking-tight">AmikomEventHub</span>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">
                Main Menu
            </p>

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }}">
                <span>🏠</span>
                <span>Dashboard</span>
            </a>

            {{-- EVENTS --}}
            <a href="{{ route('admin.events.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }}">
                <span>🎫</span>
                <span>Kelola Event</span>
            </a>

            {{-- CATEGORIES --}}
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }}">
                <span>📂</span>
                <span>Kelola Kategori</span>
            </a>

            {{-- PARTNERS --}}
            <a href="{{ route('admin.partners.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.partners.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }}">
                <span>🤝</span>
                <span>Kelola Partner</span>
            </a>
            <a href="{{ route('admin.transactions.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
            {{ request()->routeIs('admin.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }}">
                <span>🧾</span>
                <span>Laporan Transaksi</span>
            </a>

        </nav>

        {{-- TOMBOL LOGOUT --}}
        <div class="pt-6 border-t border-indigo-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black">@yield('page_title', 'Dashboard Ringkasan')</h1>
                <p class="text-slate-500 font-medium">@yield('page_subtitle', 'Selamat datang kembali, Admin!')</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="font-bold">Admin Super</p>
                    <p class="text-xs text-slate-400">Penyelenggara Utama</p>
                </div>
                <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1">
                    <img src="https://ui-avatars.com/api/?name=Admin+Super&background=6366f1&color=fff" class="rounded-xl">
                </div>
            </div>
        </header>

        {{-- Flash Message untuk Notifikasi Sukses --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Konten Dinamis Halaman CRUD --}}
        @yield('content')
    </main>

</body>
</html>
