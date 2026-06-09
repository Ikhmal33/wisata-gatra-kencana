<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Wisata Gatra Kencana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: linear-gradient(135deg, #14532d 0%, #166534 50%, #15803d 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-sm">
    {{-- Logo / Header --}}
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto overflow-hidden flex items-center justify-center ">
    <img src="{{ asset('assets/logo-gatrakencana.jpg') }}" 
         alt="Logo Gatra Kencana" 
         class="w-full h-full object-cover">
</div>
        <h1 class="text-white font-bold text-2xl">Wisata Gatra Kencana</h1>
        <p class="text-green-300 text-sm mt-1">Bojongnangka — Portal Kasir</p>
    </div>

    {{-- Login Card --}}
    <div class="bg-white rounded-2xl shadow-2xl p-6">
        <h2 class="font-bold text-gray-800 text-lg mb-5 text-center">Masuk ke Sistem</h2>

        @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 text-sm rounded-lg p-3 mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    autocomplete="username" autocapitalize="none"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                    placeholder="Masukkan username">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    autocomplete="current-password"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                    placeholder="Masukkan password">
            </div>
            <button type="submit"
                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-xl text-sm transition-colors shadow-md mt-2">
                🔐 Masuk
            </button>
        </form>

        <div class="mt-5 pt-4 border-t border-gray-100 text-center">
            <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-green-600 transition-colors">
                ← Kembali ke Halaman Wisata
            </a>
        </div>
    </div>

    <p class="text-center text-green-400 text-xs mt-6">
        © {{ date('Y') }} Wisata Gatra Kencana Bojongnangka
    </p>
</div>

</body>
</html>
