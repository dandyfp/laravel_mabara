<div id="expenseModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-slate-800 tracking-tight">Catat Pengeluaran 💸</h3>
            <button onclick="closeExpenseModal()" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>

        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase ml-2 mb-2">Nama Barang/Keperluan</label>
                <input type="text" name="name" required placeholder="Contoh: Beli Kok 1 Slop" 
                    class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-red-500 outline-none transition-all">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase ml-2 mb-2">Harga (Rp)</label>
                    <input type="number" name="amount" required placeholder="0" 
                        class="w-full px-5 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase ml-2 mb-2">Kategori</label>
                    <select name="category" class="w-full px-5 py-4 bg-slate-100 rounded-2xl outline-none">
                        <option value="shuttlecock">Shuttlecock</option>
                        <option value="court">Lapangan</option>
                        <option value="drink">Minuman</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-red-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-red-100 active:scale-95 transition-all mt-4">
                Simpan Pengeluaran
            </button>
        </form>
    </div>
</div>