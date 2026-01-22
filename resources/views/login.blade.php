<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Mabara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-sm bg-white rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200 border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ADMIN MABARA</h1>
            <p class="text-slate-400 text-sm mt-2">Silakan masuk untuk mengelola tagihan.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl text-xs font-bold mb-6 border border-red-100 text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase ml-2 mb-2">Username</label>
                <input type="text" name="username" required 
                    class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 border-transparent transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase ml-2 mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 border-transparent transition-all">
            </div>
            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-slate-800 active:scale-95 transition-all mt-4">
                Masuk Sekarang
            </button>
            <a href="{{ route('register') }}" class="block text-center text-slate-400 text-xs font-semibold hover:text-slate-600 mt-4 underline">
                Daftar Sekarang
            </a>
        </form>
    </div>
</body>
</html>