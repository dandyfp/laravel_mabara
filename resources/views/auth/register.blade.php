<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Mabara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-md bg-white rounded-[2.5rem] p-10 shadow-2xl">
        <h1 class="text-3xl font-black text-slate-800 mb-2">Daftar Akun 🏸</h1>
        <p class="text-slate-400 text-sm mb-8 font-medium">Ayo bergabung di komunitas Mabara!</p>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="text-xs font-bold text-slate-400 ml-2 uppercase">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none border-none">
            </div>

            <div>
                <label class="text-xs font-bold text-slate-400 ml-2 uppercase">Email</label>
                <input type="email" name="email" required class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none border-none">
            </div>

            <div class="mt-4">
                <label class="text-xs font-bold text-slate-400 ml-2 uppercase">Jenis Kelamin</label>
                <div class="flex gap-4 mt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="pria" class="accent-green-600" required>
                        <span class="text-sm font-medium text-slate-600">Pria</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="wanita" class="accent-green-600">
                        <span class="text-sm font-medium text-slate-600">Wanita</span>
                    </label>
                </div>
                @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-xs font-bold text-slate-400 ml-2 uppercase">Password</label>
                <input type="password" name="password" required class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none border-none">
            </div>

            <div>
                <label class="text-xs font-bold text-slate-400 ml-2 uppercase">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none border-none">
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-lg shadow-slate-200 mt-4 active:scale-95 transition-all">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center mt-8 text-sm text-slate-400 font-medium">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-green-600 font-bold hover:underline">Login</a>
        </p>
    </div>
</body>
</html>