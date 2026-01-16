<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mabara - Badminton App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans">

    <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <h1 class="text-4xl font-extrabold text-slate-800 mb-2 tracking-tight">🏸MABARA🏸</h1>
        <p class="text-slate-500 mb-10 max-w-xs">Catat main badminton jadi lebih mudah dan transparan.</p>

        <div class="w-full max-w-sm space-y-4">
            
            <button onclick="openModal()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-2xl shadow-lg transition-all transform active:scale-95 text-lg">
                Saya Mau Bayar
            </button>

            <a href="/login" class="w-full block text-center bg-white border-2 border-slate-200 text-slate-600 font-semibold py-4 rounded-2xl hover:bg-slate-50 transition-all text-lg">
                Login Admin
            </a>
        </div>
    </div>

    <div id="paymentModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800">Data Main Hari Ini</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
            </div>

            <form id="formBayar" action="{{route('transactions.store')}}" method="POST" onsubmit="return validateForm(event)">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pemain *</label>
                    <input type="text" name="player_name" id="player_name" 
                        class="w-full px-4 py-3 bg-slate-100 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:outline-none transition-all" 
                        placeholder="Contoh: Budi Santoso">
                    <p id="error-name" class="text-red-500 text-xs mt-1 hidden font-medium">Nama harus diisi!</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Main Berapa Kali? *</label>
                    <select name="play_count" id="play_count" onchange="calculateTotal()" 
                        class="w-full px-4 py-3 bg-slate-100 border border-transparent rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 appearance-none">
                        <option value="">-- Pilih Sesi --</option>
                        <option value="1">1x Main (Rp 8.000)</option>
                        <option value="2">2x Main (Rp 10.000)</option>
                        <option value="3">3x Main atau lebih (Rp 12.000)</option>
                    </select>
                    <p id="error-play" class="text-red-500 text-xs mt-1 hidden font-medium">Silakan pilih jumlah main!</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Shuttlecock *</label>
                    <div class="relative">
                        <input type="number" name="shuttlecock_count" id="shuttlecock_count" 
                            value="0" min="0" oninput="calculateTotal()" 
                            class="w-full px-4 py-3 bg-slate-100 border border-transparent rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Isi 0 jika tidak pakai">
                    </div>
                    <p id="error-cock" class="text-red-500 text-xs mt-1 hidden font-medium">Isi minimal 1!</p>
                </div>

                <div class="bg-slate-900 p-5 rounded-2xl mb-6 flex justify-between items-center shadow-inner">
                    <span class="text-slate-400 font-medium">Total Tagihan</span>
                    <span id="displayTotal" class="text-2xl font-bold text-green-400">Rp 0</span>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-green-700 active:scale-95 transition-all text-lg" onclick="this.innerHTML='Sedang Menyimpan...'; this.classList.add('opacity-50')">
                    Konfirmasi & Simpan
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('paymentModal').classList.replace('hidden', 'flex');
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.replace('flex', 'hidden');
            resetForm();
        }

        function resetForm() {
            document.getElementById('formBayar').reset();
            document.getElementById('displayTotal').innerText = "Rp 0";
            hideErrors();
        }

        function hideErrors() {
            ['error-name', 'error-play', 'error-cock'].forEach(id => {
                document.getElementById(id).classList.add('hidden');
            });
        }

        function calculateTotal() {
            const playCount = document.getElementById('play_count').value;
            const cockCount = parseInt(document.getElementById('shuttlecock_count').value) || 0;
            
            let courtFee = 0;
            if(playCount == 1) courtFee = 8000;
            else if(playCount == 2) courtFee = 10000;
            else if(playCount == 3) courtFee = 12000;

            const total = courtFee + (cockCount * 3000);
            
            if(playCount === "") {
                document.getElementById('displayTotal').innerText = "Rp 0";
            } else {
                document.getElementById('displayTotal').innerText = "Rp " + total.toLocaleString('id-ID');
            }
        }

        function validateForm(event) {
            hideErrors();
            let isValid = true;

            const name = document.getElementById('player_name').value.trim();
            const play = document.getElementById('play_count').value;
            const cock = document.getElementById('shuttlecock_count').value;

            if (name === "") {
                document.getElementById('error-name').classList.remove('hidden');
                isValid = false;
            }

            if (play === "") {
                document.getElementById('error-play').classList.remove('hidden');
                isValid = false;
            }

            if (cock === "" || cock <= 0) {
                document.getElementById('error-cock').classList.remove('hidden');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Jangan submit jika tidak valid
            }
            
            return isValid;
        }
    </script>
</body>
</html>