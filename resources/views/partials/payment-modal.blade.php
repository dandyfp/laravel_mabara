<div id="paymentModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl overflow-hidden">
        <div class="flex justify-between items-center mb-6">
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Data Main Hari Ini</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>

        <form id="formBayar" action="{{ route('transactions.store') }}" method="POST" onsubmit="return validateForm(event)">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pemain *</label>
                <input type="text" name="player_name" id="player_name" placeholder="Masukkan nama pemain" class="w-full px-4 py-3 bg-slate-100 rounded-xl focus:ring-2 focus:ring-green-500 outline-none">
                <p id="error-name" class="text-red-500 text-xs mt-1 hidden font-medium">Nama wajib diisi!</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Main Berapa Kali? 
                    @guest <span class="text-red-500">*</span> @endguest
                </label>
                <select name="play_count" id="play_count" onchange="calculateTotal()" class="w-full px-4 py-3 bg-slate-100 rounded-xl outline-none">
                    <option value="">-- Pilih Sesi --</option>
                    <option value="1">1x Main (Rp 8.000)</option>
                    <option value="2">2x Main (Rp 10.000)</option>
                    <option value="3">3x Main atau lebih (Rp 12.000)</option>
                </select>
                <p id="error-play" class="text-red-500 text-xs mt-1 hidden font-medium">Pilih jumlah main!</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2 text-left">Jumlah Shuttlecock</label>
                <div class="flex items-center bg-slate-100 rounded-xl p-1 border border-transparent focus-within:ring-2 focus-within:ring-green-500 transition-all">
                    <button type="button" onclick="stepNumber(-1)" class="w-12 h-12 flex items-center justify-center bg-white rounded-lg shadow-sm">−</button>
                    <input type="number" name="shuttlecock_count" id="shuttlecock_count" value="0" min="0" oninput="calculateTotal()" onfocus="clearZero(this)" onblur="restoreZero(this)" class="w-full bg-transparent text-center font-bold text-lg focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                    <button type="button" onclick="stepNumber(1)" class="w-12 h-12 flex items-center justify-center bg-white rounded-lg shadow-sm">+</button>
                </div>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl mb-6 flex justify-between items-center shadow-inner">
                <span class="text-slate-400 font-medium">Total Tagihan</span>
                <span id="displayTotal" class="text-2xl font-bold text-green-400">Rp 0</span>
            </div>

            <button type="submit" id="submitBtn" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                Konfirmasi & Simpan
            </button>
        </form>
    </div>
</div>

<script>
    const isAdmin = {{ Auth::check() ? 'true' : 'false' }};

    function openModal(player = null) {
        const modal = document.getElementById('paymentModal');
        const form = document.getElementById('formBayar');
        const methodInput = document.getElementById('formMethod');
        const title = document.getElementById('modalTitle');
        const submitBtn = document.getElementById('submitBtn');

        resetErrors(); // Bersihkan error setiap buka modal

        if (player) {
            title.innerText = "Edit Data Pemain";
            form.action = "/transactions/" + player.id; 
            methodInput.value = "PUT";
            submitBtn.innerHTML = "Update Data";

            document.getElementById('player_name').value = player.player_name;
            document.getElementById('play_count').value = player.play_count || "";
            document.getElementById('shuttlecock_count').value = player.shuttlecock_count || 0;
            calculateTotal();
        } else {
            title.innerText = "Data Main Hari Ini";
            form.action = "{{ route('transactions.store') }}";
            methodInput.value = "POST";
            submitBtn.innerHTML = "Konfirmasi & Simpan";
            document.getElementById('formBayar').reset();
            document.getElementById('displayTotal').innerText = "Rp 0";
        }
        modal.classList.replace('hidden', 'flex');
    }

    function closeModal() {
        document.getElementById('paymentModal').classList.replace('flex', 'hidden');
    }

    function calculateTotal() {
        const playCount = document.getElementById('play_count').value;
        const cockCount = parseInt(document.getElementById('shuttlecock_count').value) || 0;
        let courtFee = 0;
        if(playCount == 1) courtFee = 8000;
        else if(playCount == 2) courtFee = 10000;
        else if(playCount == 3) courtFee = 12000;
        const total = courtFee + (cockCount * 3000);
        document.getElementById('displayTotal').innerText = playCount === "" ? "Rp 0" : "Rp " + total.toLocaleString('id-ID');
    }

    function stepNumber(step) {
        const input = document.getElementById('shuttlecock_count');
        let val = (parseInt(input.value) || 0) + step;
        if (val >= 0) { input.value = val; calculateTotal(); }
    }

    function clearZero(input) { if (input.value === "0") input.value = ""; }
    function restoreZero(input) { if (input.value === "") input.value = "0"; }

    function resetErrors() {
        document.getElementById('error-name').classList.add('hidden');
        document.getElementById('error-play').classList.add('hidden');
    }

    function validateForm(event) {
        resetErrors();
        let isValid = true;
        const name = document.getElementById('player_name').value.trim();
        const play = document.getElementById('play_count').value;
        const btn = document.getElementById('submitBtn');

        // Validasi Nama (Wajib untuk siapapun)
        if (!name) {
            document.getElementById('error-name').classList.remove('hidden');
            isValid = false;
        }

        // Validasi Main (Wajib untuk Guest, Opsional untuk Admin)
        if (!isAdmin && !play) {
            document.getElementById('error-play').classList.remove('hidden');
            isValid = false;
        }

        if (isValid) {
            // Hanya disable jika validasi lolos
            btn.disabled = true;
            btn.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 mr-3 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                </span>
            `;
            return true;
        } else {
            // Jangan submit jika tidak valid
            event.preventDefault();
            return false;
        }
    }
</script>