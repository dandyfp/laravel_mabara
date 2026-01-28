<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kas - Mabara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 pb-20">

    <div class="bg-slate-900 pt-8 pb-24 px-6 rounded-b-[3rem] relative shadow-2xl">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('transactions.index') }}" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white border border-white/10 active:scale-90 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h1 class="text-white font-bold text-sm uppercase tracking-widest">Detail Arus Kas</h1>
            <div class="w-10"></div> </div>

        <div class="text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-2">Sisa Saldo Saat Ini</p>
            <h2 class="text-white text-4xl font-black tracking-tighter">
                Rp {{ number_format($closing_balance, 0, ',', '.') }}
            </h2>
        </div>
    </div>

    <div class="px-6 -mt-10 relative z-10">
        <div class="bg-white p-5 rounded-[2rem] shadow-xl shadow-slate-200 border border-slate-100 mb-6">
            <form action="{{ route('cash.ledger') }}" method="GET" class="flex items-center gap-3">
                <div class="flex-1 bg-slate-50 p-2 rounded-2xl border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase ml-2 mb-1">Filter Periode</p>
                    <div class="flex items-center gap-2">
                        <input type="date" name="start" value="{{ request('start') }}" class="bg-transparent text-xs font-bold text-slate-700 outline-none w-full px-2">
                        <span class="text-slate-300 text-xs">-</span>
                        <input type="date" name="end" value="{{ request('end') }}" class="bg-transparent text-xs font-bold text-slate-700 outline-none w-full px-2">
                    </div>
                </div>
                <button type="submit" class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center shadow-lg active:scale-90 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </button>
            </form>
        </div>

        <div class="space-y-3">
            <h3 class="text-slate-800 font-extrabold text-sm ml-2 mb-4">Aktivitas Terakhir</h3>
            
            @forelse($ledgers as $log)
            <div class="bg-white p-4 rounded-3xl flex justify-between items-center shadow-sm border border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 {{ $log->type == 'in' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-500' }} rounded-2xl flex items-center justify-center text-xl">
                        {{ $log->type == 'in' ? '📈' : '📉' }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm leading-tight">{{ $log->description }}</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">
                            {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y • H:i') }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-black text-sm {{ $log->type == 'in' ? 'text-green-600' : 'text-red-500' }}">
                        {{ $log->type == 'in' ? '+' : '-' }} Rp {{ number_format($log->amount, 0, ',', '.') }}
                    </p>
                    <p class="text-[9px] text-slate-300 font-bold mt-1">Saldo: Rp {{ number_format($log->current_balance, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-[2rem] p-10 text-center border-2 border-dashed border-slate-200">
                <p class="text-slate-400 text-sm font-medium italic">Belum ada mutasi kas.</p>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>