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
            <div class="w-10"></div> 
        </div>

        <div class="text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-2">Sisa Saldo Saat Ini</p>
            <h2 class="text-white text-4xl font-black tracking-tighter">
                Rp {{ number_format($closing_balance, 0, ',', '.') }}
            </h2>
        </div>
    </div>

    <div class="px-6 -mt-10 relative z-10">
        <!-- <div class="bg-white p-5 rounded-[2rem] shadow-xl shadow-slate-200 border border-slate-100 mb-6">
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
        </div> -->
        <div class="bg-white p-4 rounded-[2rem] shadow-xl shadow-slate-200 border border-slate-100 mb-6">
    
    <div class="flex justify-between items-center mb-3 px-1">
        <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Filter & Saldo</p>
        
        <button onclick="openIncomeModal()" class="group flex items-center gap-1.5 bg-green-50 hover:bg-green-100 text-green-600 border border-green-100 px-3 py-1.5 rounded-full transition-all active:scale-95">
            <div class="w-4 h-4 bg-green-500 text-white rounded-full flex items-center justify-center text-[8px] shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wide">Isi Saldo</span>
        </button>
    </div>

    <form action="{{ route('cash.ledger') }}" method="GET" class="flex items-center gap-2">
        <div class="flex-1 bg-slate-50 p-1.5 rounded-xl border border-slate-100 flex items-center gap-2">
            <input type="date" name="start" value="{{ request('start') }}" class="bg-transparent text-[10px] font-bold text-slate-600 outline-none w-full px-1">
            <span class="text-slate-300 text-[10px]">-</span>
            <input type="date" name="end" value="{{ request('end') }}" class="bg-transparent text-[10px] font-bold text-slate-600 outline-none w-full px-1">
        </div>
        <button type="submit" class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center shadow-md active:scale-90 transition-all hover:bg-slate-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
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
                    
                    @if($log->type == 'out')
                    <form action="{{ route('cash.ledger.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus data ini? Saldo akan dikembalikan otomatis.')" class="mt-2">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-[8px] font-black text-red-400 border border-red-100 px-2 py-1 rounded-lg uppercase tracking-widest hover:bg-red-50 transition-all">
                            Hapus & Koreksi
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-[2rem] p-10 text-center border-2 border-dashed border-slate-200">
                <p class="text-slate-400 text-sm font-medium italic">Belum ada mutasi kas.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div id="expenseModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-6 z-[100]">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl overflow-hidden relative">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-800">Catat Biaya 💸</h3>
                <button onclick="closeExpenseModal()" class="text-slate-300 hover:text-slate-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form action="{{ route('expenses.store') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase ml-2 mb-2">Apa yang dibeli?</label>
                    <input type="text" name="name" required placeholder="Contoh: Beli Kok, Sewa Lapangan" 
                        class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-rose-500 outline-none border-none text-sm font-bold text-slate-700 transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase ml-2 mb-2">Nominal (Rp)</label>
                    <input type="number" name="amount" required placeholder="0" 
                        class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-rose-500 outline-none border-none text-sm font-bold text-slate-700 transition-all">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-rose-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-rose-200 active:scale-95 transition-all uppercase tracking-widest text-xs">
                        Simpan & Potong Saldo
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="incomeModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-6 z-[100]">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl overflow-hidden relative">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-800">Tambah Saldo 💰</h3>
                <button onclick="closeIncomeModal()" class="text-slate-300 hover:text-slate-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form action="{{ route('cash.ledger.store-income') }}" method="POST" class="space-y-5">
                @csrf
                <div class="mb-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase ml-2 mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none border-none text-sm font-bold text-slate-700">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase ml-2 mb-2">Sumber Dana / Keterangan</label>
                    <input type="text" name="description" required placeholder="Contoh: Sisa Kas Buku Lama, Donasi" 
                        class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none border-none text-sm font-bold text-slate-700 transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase ml-2 mb-2">Nominal (Rp)</label>
                    <input type="number" name="amount" required placeholder="0" 
                        class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none border-none text-sm font-bold text-slate-700 transition-all">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-green-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-green-200 active:scale-95 transition-all uppercase tracking-widest text-xs">
                        Simpan Pemasukan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="fixed bottom-8 left-0 right-0 flex justify-center z-40 pointer-events-none">
        <button onclick="openExpenseModal()" class="pointer-events-auto bg-slate-900 text-white rounded-full p-2 pr-6 shadow-2xl shadow-slate-900/40 flex items-center gap-4 transition-all active:scale-95 group hover:bg-slate-800 border border-slate-700/50 backdrop-blur-md">

            <div class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-xl shadow-lg shadow-rose-500/30 group-hover:rotate-90 transition-transform duration-300">
                💸
            </div>

            <div class="text-left">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider leading-none mb-0.5">Ada Pengeluaran?</p>
                <p class="text-sm font-black text-white leading-none">Catat Disini</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 group-hover:text-white transition-colors ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <script>
        function openExpenseModal() {
            const modal = document.getElementById('expenseModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeExpenseModal() {
            const modal = document.getElementById('expenseModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal if clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('expenseModal');
            if (event.target == modal) {
                closeExpenseModal();
            }
        }
        function openIncomeModal() {
            const modal = document.getElementById('incomeModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeIncomeModal() {
            const modal = document.getElementById('incomeModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        // ====================================

        // Update fungsi klik outside agar bisa menutup kedua modal
        window.onclick = function(event) {
            const expenseModal = document.getElementById('expenseModal');
            const incomeModal = document.getElementById('incomeModal');
            
            if (event.target == expenseModal) {
                closeExpenseModal();
            }
            if (event.target == incomeModal) {
                closeIncomeModal();
            }
        }
    </script>
</body>
</html>