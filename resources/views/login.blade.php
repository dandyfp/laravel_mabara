<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Mabara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6 relative">

    @if(session('error') || $errors->any())
    <div id="snackbar" class="fixed top-5 left-1/2 -translate-x-1/2 z-[60] flex items-center bg-red-600 text-white px-6 py-3 rounded-2xl shadow-2xl transition-all duration-500 transform translate-y-0 opacity-100">
        <i data-lucide="alert-circle" class="w-5 h-5 mr-3"></i>
        <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
    </div>
    @endif

    <div class="w-full max-w-sm bg-white rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200 border border-slate-100">
        <div class="mb-6">
            <a href="/" class="inline-flex items-center justify-center w-11 h-11 bg-white border-2 border-black rounded-full hover:bg-slate-50 transition-all active:scale-90 group">
                <i data-lucide="arrow-left" class="w-6 h-6 text-black"></i>
            </a>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Login Admin</h1>
            <p class="text-slate-400 text-sm mt-2">Silakan masuk untuk mengelola tagihan.</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase ml-2 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 border-transparent transition-all"
                    placeholder="nama@email.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase ml-2 mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required 
                        class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 border-transparent transition-all"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                        <i id="eyeIcon" data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-slate-800 active:scale-95 transition-all mt-4">
                Masuk Sekarang
            </button>

            <a href="{{ route('register') }}" class="block text-center text-slate-400 text-xs font-semibold hover:text-slate-600 mt-4 underline">
                Daftar Sekarang
            </button>
        </form>
    </div>

    <script>
        // Inisialisasi Icon Lucide
        lucide.createIcons();

        // Fungsi Toggle Password
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordField.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons(); // Re-render icons
        }

        // Auto-hide Snackbar setelah 3 detik
        const snackbar = document.getElementById('snackbar');
        if(snackbar) {
            setTimeout(() => {
                snackbar.classList.add('opacity-0', '-translate-y-10');
                setTimeout(() => snackbar.remove(), 500);
            }, 3000);
        }
    </script>
</body>
</html>