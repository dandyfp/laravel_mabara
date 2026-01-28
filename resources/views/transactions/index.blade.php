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
        /* Transisi halus saat filter */
        .player-card { transition: all 0.3s ease; }
        .player-card.hidden { display: none; opacity: 0; transform: translateY(10px); }
    </style>
</head>
<body class="bg-slate-100 pb-24">

    <div class="bg-green-600 pt-5 pb-16 px-4 rounded-b-[3rem] shadow-xl relative">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-white text-2xl font-extrabold tracking-tight">MABARA 🏸</h1>
                <p class="text-green-100 text-xs font-medium">Laporan Sesi: {{ \Carbon\Carbon::parse($report['date'])->translatedFormat('d F Y') }}</p>
            </div>
            <div class="flex gap-2">
                @auth 
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="bg-red-500 text-white text-[10px] font-bold py-2 px-4 rounded-xl italic shadow-lg shadow-red-900/20">
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
            @auth 
            <div class="mt-4 flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
            <a href="{{ route('cash.ledger') }}" class="flex-none bg-white/10 hover:bg-white/20 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 flex items-center gap-3 transition-all">
                <div class="w-8 h-8 bg-amber-400 rounded-lg flex items-center justify-center text-sm shadow-lg shadow-amber-900/20">💰</div>
                <div>
                    <p class="text-[9px] text-green-100 uppercase font-black tracking-widest leading-none mb-1">Total Saldo Kas</p>
                    <p class="text-sm font-black text-white leading-none">Rp {{ number_format($global_closing_balance, 0, ',', '.') }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        @endauth
    </div>

    <div class="px-4 -mt-12 relative z-10">
        
        <div class="bg-white p-5 rounded-[2.5rem] shadow-xl shadow-slate-200/50 mb-4">
            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-center px-2">
                    <h2 class="text-slate-800 font-extrabold text-lg flex items-center gap-2">
                        List Pemain 
                    </h2>
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                        {{ count($report['players']) }} Orang
                    </span>
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" onkeyup="filterPlayers()" 
                        placeholder="Cari nama pemain..." 
                        class="w-full pl-11 pr-4 py-3 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-green-500 outline-none text-sm text-slate-600 font-medium transition-all">
                </div>
            </div>
        </div>

        <div class="space-y-2" id="playersContainer">
            @forelse($report['players'] as $player)
            <div class="player-card bg-white p-5 rounded-[2rem] shadow-sm border border-slate-200/50 flex justify-between items-center active:scale-[0.98]">
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-slate-100">
                        👤
                    </div>
                    <div>
                        <span class="text-slate-800 font-bold text-base block player-name">{{ $player['player_name'] }}</span>
                        <div class="flex items-center gap-3 mt-0.5">
                            <p class="text-slate-400 text-[11px] font-semibold">{{ $player['play_count'] }}x Main</p>
                            <span class="text-slate-200 text-[10px]">|</span> 
                            <p class="text-slate-400 text-[11px] font-semibold uppercase tracking-wider">{{ $player['shuttlecock_count'] ?? 0 }} Cock</p>
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
                        <span class="inline-flex items-center gap-1 text-[9px] font-black uppercase bg-slate-50 px-3 py-1.5 rounded-lg {{ $player['status'] == 'paid' ? 'text-green-600' : 'text-amber-500 italic' }}">
                            {{ $player['status'] == 'paid' ? 'PAID' : 'PENDING' }}
                        </span>
                    @endauth
                </div>
            </div>
            @empty
            <div class="bg-white rounded-[2rem] p-10 text-center border-2 border-dashed border-slate-200">
                <p class="text-slate-400 text-sm font-medium italic">Belum ada pemain yang terdaftar.</p>
            </div>
            @endforelse
        </div>
    </div>

    <button onclick="openModal()" class="fixed bottom-6 right-6 left-6 bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-2xl shadow-slate-900/20 flex items-center justify-center gap-2 hover:bg-slate-800 transition-all active:scale-95 z-40">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
        @auth TAMBAH PEMAIN @else SAYA MAU BAYAR @endauth
    </button>

    @include('partials.payment-modal')

    <script>
        function filterPlayers() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const container = document.getElementById('playersContainer');
            const cards = container.getElementsByClassName('player-card');

            for (let i = 0; i < cards.length; i++) {
                const name = cards[i].querySelector('.player-name').innerText.toLowerCase();
                if (name.indexOf(filter) > -1) {
                    cards[i].classList.remove('hidden');
                } else {
                    cards[i].classList.add('hidden');
                }
            }
        }

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