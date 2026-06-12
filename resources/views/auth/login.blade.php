<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-indigo-900 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white text-slate-900 rounded-[2rem] p-8 shadow-2xl">

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">AH</div>
            <h1 class="text-2xl font-black">Admin Login</h1>
            <p class="text-slate-500">AmikomEventHub Dashboard</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-4 rounded-xl mb-6 font-bold text-sm text-center border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 rounded-2xl outline-none transition font-medium
                    @error('email') border-red-500 focus:ring-4 focus:ring-red-500/10 focus:border-red-600 @else border-slate-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 @enderror"
                    required>

                @error('email')
                    <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Password</label>
                <input type="password" name="password"
                    class="w-full px-5 py-4 bg-slate-50 border-2 rounded-2xl outline-none transition font-medium
                    @error('password') border-red-500 focus:ring-4 focus:ring-red-500/10 focus:border-red-600 @else border-slate-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 @enderror"
                    required>

                @error('password')
                    <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Masuk</button>
        </form>

    </div>

</body>
</html>
