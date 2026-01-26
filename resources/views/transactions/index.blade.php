<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tagihan - Mabara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 pb-24">

    <div class="bg-green-600 pt-10 pb-20 px-6 rounded-b-[3rem] shadow-xl relative">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-white text-2xl font-extrabold tracking-tight">MABARA 🏸</h1>
                <p class="text-green-100 text-xs">Laporan Sesi: {{ \Carbon\Carbon::parse($report['date'])->translatedFormat('d F Y') }}</p>
            </div>
            <div class="flex gap-2">
                @auth 
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="bg-red-500 text-white text-[10px] font-bold py-2 px-4 rounded-xl italic">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white/20 text-white text-xs font-bold py-2 px-4 rounded-xl border border-white/20">
                        Login Admin
                    </a>
                @endauth
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="bg-white/20 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                <p class="text-[10px] text-green-100 uppercase font-bold tracking-wider mb-1">Total Income</p>
                <p class="text-xl font-extrabold text-white leading-none">Rp {{ number_format($report['summary']['total_income'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                <p class="text-[10px] text-green-100 uppercase font-bold tracking-wider mb-1">Lunas (Paid)</p>
                <p class="text-xl font-extrabold text-white leading-none text-green-300 italic">Rp {{ number_format($report['summary']['paid'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="px-6 -mt-8 relative z-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-slate-800 font-extrabold text-lg flex items-center gap-2">
                List Pemain 
                <span class="bg-slate-800 text-white text-[10px] px-2 py-0.5 rounded-md">{{ count($report['players']) }}</span>
            </h2>
        </div>

        <div class="space-y-4">
            @forelse($report['players'] as $player)
            <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-slate-200/50 flex justify-between items-center transition-transform active:scale-[0.98]">
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                        👤
                    </div>
                    <div>
                        <span class="text-slate-800 font-bold text-base block">{{ $player['player_name'] }}</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <p class="text-slate-400 text-xs font-medium">{{ $player['play_count'] }}x Main</p>
                            <span class="text-slate-300 text-[10px]">•</span> 
                            <p class="text-slate-400 text-xs font-medium flex items-center gap-1">
                                <span class="opacity-70 text-[10px]">🏸</span>
                                {{ $player['shuttlecock_count'] ?? 0 }} Cock
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <p class="font-extrabold text-slate-900 text-sm mb-1">Rp {{ number_format($player['total_fee'], 0, ',', '.') }}</p>
                        @auth
                        <div class="flex items-center gap-2">
                            <button onclick='openModal({!! json_encode($player) !!})'
                                    class="p-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>

                            <form action="{{ route('admin.mark-paid', $player['id']) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" 
                                    class="flex items-center gap-1.5 text-[10px] font-black px-4 py-2.5 rounded-xl transition-all active:scale-95 shadow-sm {{ $player['status'] == 'paid' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-amber-500 text-white hover:bg-amber-600' }}">
                                    {{ $player['status'] == 'paid' ? 'LUNAS' : 'KONFIRMASI?' }}
                                </button>
                            </form>
                        </div>
                        @else
                            <span class="inline-flex items-center gap-1 text-[9px] font-black uppercase bg-slate-50 px-2 py-1 rounded-lg {{ $player['status'] == 'paid' ? 'text-green-600' : 'text-amber-500 italic' }}">
                                {{ $player['status'] == 'paid' ? 'PAID' : 'PENDING' }}
                            </span>
                        @endauth
                </div>
            </div>
            @empty
            <div class="bg-white rounded-[2rem] p-10 text-center border-2 border-dashed border-slate-200">
                <p class="text-slate-400 text-sm font-medium">Belum ada pemain yang terdaftar.</p>
            </div>
            @endforelse
        </div>
    </div>

    <button onclick="openModal()" class="fixed bottom-6 right-6 left-6 bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-2xl flex items-center justify-center gap-2 hover:bg-slate-800 transition-all active:scale-95 z-40">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
        @auth TAMBAH PEMAIN @else SAYA MAU BAYAR LAGI @endauth
    </button>

    @include('partials.payment-modal')

    @if(session('success'))
    <div id="snackbar" class="fixed bottom-24 left-6 right-6 z-[100] transition-all duration-500">
        <div class="bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl border border-slate-700 flex items-center gap-3">
             <div class="bg-green-500 rounded-full p-1 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <p class="text-xs font-bold">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <script>
        // Snackbar hide logic
        @if(session('success'))
            setTimeout(() => { 
                const s = document.getElementById('snackbar');
                if(s) { 
                    s.style.opacity = '0'; 
                    setTimeout(() => s.remove(), 500); 
                }
            }, 4000);
        @endif
    </script>
</body>
</html>