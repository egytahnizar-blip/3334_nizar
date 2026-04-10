<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-50 min-h-screen p-8 text-purple-900 font-sans">

    <nav class="flex flex-wrap justify-center gap-4 mb-10">
        <a href="/" class="bg-white text-purple-600 px-5 py-2 rounded-full font-semibold hover:bg-purple-600 hover:text-white transition duration-300 shadow-md">Home</a>
        <a href="/profil" class="bg-white text-purple-600 px-5 py-2 rounded-full font-semibold hover:bg-purple-600 hover:text-white transition duration-300 shadow-md">Profil</a>
        <a href="/katalog" class="bg-purple-700 text-white px-5 py-2 rounded-full font-semibold shadow-md">Katalog</a>
        <a href="/bantuan" class="bg-white text-purple-600 px-5 py-2 rounded-full font-semibold hover:bg-purple-600 hover:text-white transition duration-300 shadow-md">Bantuan</a>
        <a href="/kontak" class="bg-white text-purple-600 px-5 py-2 rounded-full font-semibold hover:bg-purple-600 hover:text-white transition duration-300 shadow-md">Kontak</a>
    </nav>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-purple-800 mb-8">Katalog AmikomEventHub</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 group cursor-pointer">
                <div class="h-40 bg-purple-300 flex items-center justify-center group-hover:bg-purple-400 transition">
                    <span class="text-4xl">🎤</span>
                </div>
                <div class="p-5">
                    <h2 class="font-bold text-xl mb-2 text-purple-800">Seminar Teknologi 2024</h2>
                    <p class="text-sm text-purple-600 mb-4">Membahas tren AI terbaru dalam industri kreatif.</p>
                    <button class="w-full bg-purple-100 text-purple-700 py-2 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition">Lihat Detail</button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 group cursor-pointer">
                <div class="h-40 bg-purple-300 flex items-center justify-center group-hover:bg-purple-400 transition">
                    <span class="text-4xl">💻</span>
                </div>
                <div class="p-5">
                    <h2 class="font-bold text-xl mb-2 text-purple-800">Workshop Laravel</h2>
                    <p class="text-sm text-purple-600 mb-4">Pelatihan intensif membuat web dengan framework Laravel.</p>
                    <button class="w-full bg-purple-100 text-purple-700 py-2 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition">Lihat Detail</button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 group cursor-pointer">
                <div class="h-40 bg-purple-300 flex items-center justify-center group-hover:bg-purple-400 transition">
                    <span class="text-4xl">🏆</span>
                </div>
                <div class="p-5">
                    <h2 class="font-bold text-xl mb-2 text-purple-800">Lomba UI/UX Design</h2>
                    <p class="text-sm text-purple-600 mb-4">Kompetisi merancang antarmuka aplikasi mahasiswa.</p>
                    <button class="w-full bg-purple-100 text-purple-700 py-2 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition">Lihat Detail</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
