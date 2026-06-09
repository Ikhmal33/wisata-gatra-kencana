<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Tiket — Wisata Gatra Kencana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F9F9F5',
                        emerald: '#2A9D6F',
                        forest: '#1E2522',
                        charcoal: '#2D312E',
                        muted: '#707771',
                        gold: '#EAA83A'
                    },
                    fontFamily: {
                        serif: ['"DM Serif Display"', 'serif'],
                        sans: ['"DM Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #F9F9F5; color: #2D312E; }
        .font-serif { font-family: 'DM Serif Display', serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <nav class="bg-white border-b border-gray-200 py-3 sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/logo-gatrakencana.jpg') }}" alt="Logo Gatra Kencana" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="font-serif text-sm leading-none text-forest">Gatra Kencana</p>
                    <p class="text-[10px] text-muted mt-0.5">Form Booking Tiket</p>
                </div>
            </div>
            <a href="/" class="text-xs font-bold text-emerald border border-emerald px-3 py-2 rounded-full hover:bg-emerald hover:text-white transition-all flex items-center gap-1">
                ⬅️ Kembali ke Beranda
            </a>
        </div>
    </nav>

    <main class="flex-grow py-8 px-4">
        <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-emerald text-white p-4 text-center">
                <h2 class="font-serif text-xl">Formulir Pesan Tiket</h2>
                <p class="text-xs text-emerald-100 mt-1">Isi data dan jumlah tiket untuk dikirim ke WhatsApp Admin</p>
            </div>

            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-charcoal mb-1">Nama Lengkap</label>
                    <input type="text" id="cust_name" placeholder="Masukkan nama sesuai KTP" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald outline-none font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-charcoal mb-1">Nomor WhatsApp</label>
                    <input type="number" id="cust_phone" placeholder="Contoh: 08123456789" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald outline-none font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-charcoal mb-1">Tanggal Booking Kunjungan</label>
                    <input type="date" id="cust_date" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald outline-none font-bold text-gray-700">
                </div>

                <div class="border-t border-dashed border-gray-200 pt-3">
                    <p class="text-center font-serif text-xs text-muted tracking-wide">------- Booking Tiket -------</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-3 flex flex-col items-center justify-center border border-gray-100">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Mode Harga</span>
                    <span class="text-sm font-bold text-emerald mt-0.5">{{ $modeLabel }}</span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                        <div>
                            <p class="font-bold text-charcoal text-sm">👨 Dewasa</p>
                            <p class="text-xs text-muted font-medium">Rp {{ number_format($selectedPrices['adult'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <button type="button" onclick="adjustQty('adult_qty', -1)" class="w-8 h-8 rounded-full bg-red-100 text-red-700 font-bold flex items-center justify-center hover:bg-red-200 transition-colors">−</button>
                            <input type="number" id="adult_qty" value="0" min="0" data-price="{{ $selectedPrices['adult'] }}" oninput="calculateTotal()" class="w-10 text-center bg-transparent font-bold text-sm outline-none" readonly>
                            <button type="button" onclick="adjustQty('adult_qty', 1)" class="w-8 h-8 rounded-full bg-emerald/10 text-emerald font-bold flex items-center justify-center hover:bg-emerald/20 transition-colors">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                        <div>
                            <p class="font-bold text-charcoal text-sm">👦 Anak</p>
                            <p class="text-xs text-muted font-medium">Rp {{ number_format($selectedPrices['child'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <button type="button" onclick="adjustQty('child_qty', -1)" class="w-8 h-8 rounded-full bg-red-100 text-red-700 font-bold flex items-center justify-center hover:bg-red-200 transition-colors">−</button>
                            <input type="number" id="child_qty" value="0" min="0" data-price="{{ $selectedPrices['child'] }}" oninput="calculateTotal()" class="w-10 text-center bg-transparent font-bold text-sm outline-none" readonly>
                            <button type="button" onclick="adjustQty('child_qty', 1)" class="w-8 h-8 rounded-full bg-emerald/10 text-emerald font-bold flex items-center justify-center hover:bg-emerald/20 transition-colors">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                        <div>
                            <p class="font-bold text-charcoal text-sm">🎫 Terusan</p>
                            <p class="text-xs text-muted font-medium">Rp {{ number_format($selectedPrices['terusan'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <button type="button" onclick="adjustQty('terusan_qty', -1)" class="w-8 h-8 rounded-full bg-red-100 text-red-700 font-bold flex items-center justify-center hover:bg-red-200 transition-colors">−</button>
                            <input type="number" id="terusan_qty" value="0" min="0" data-price="{{ $selectedPrices['terusan'] }}" oninput="calculateTotal()" class="w-10 text-center bg-transparent font-bold text-sm outline-none" readonly>
                            <button type="button" onclick="adjustQty('terusan_qty', 1)" class="w-8 h-8 rounded-full bg-emerald/10 text-emerald font-bold flex items-center justify-center hover:bg-emerald/20 transition-colors">+</button>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <p class="text-xs font-semibold text-muted">Total Pembayaran Tiket</p>
                    <div class="flex justify-between items-baseline mt-0.5">
                        <span id="total-display" class="text-2xl font-bold text-emerald tabular-nums">Rp 0</span>
                        <span id="total-qty" class="text-xs font-bold text-muted bg-gray-100 px-2 py-1 rounded-md">0 Tiket</span>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-200 pt-3">
                    <p class="text-center font-serif text-xs text-muted tracking-wide">------- Pesan By WhatsApp -------</p>
                </div>

                <button type="button" onclick="sendToWhatsApp()" class="w-full bg-[#25D366] text-white font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 hover:bg-[#20ba5a] active:scale-[0.99] transition-all shadow-md">
                    💬 Kirim Data Booking ke WhatsApp
                </button>
            </div>
        </div>
    </main>

    <footer style="background: #1E2522; color: rgba(255,255,255,0.45); padding: 48px 0 28px;" class="w-full mt-12">
        <div class="w-full px-4" style="max-width:1024px;margin:0 auto;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 text-left">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div style="width:34px; height:34px; border-radius:9px; overflow:hidden; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <img src="{{ asset('assets/logo-gatrakencana.jpg') }}" alt="Logo Gatra Kencana" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div>
                            <p class="font-serif" style="color:white;font-size:0.875rem;">Gatra Kencana</p>
                            <p style="font-size:0.65rem;color:rgba(255,255,255,0.3);">Wisata Keluarga</p>
                        </div>
                    </div>
                    <p style="font-size:0.82rem;line-height:1.7;max-width:220px;">Destinasi wisata keluarga terfavorit di Bojongnangka, Jawa Tengah.</p>
                </div>

                <div>
                    <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:12px;">Navigasi</p>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach(['/#tentang'=>'Tentang Kami','/#galeri'=>'Galeri','/#harga'=>'Harga Tiket','/#kabar'=>'Kabar Terkini','/#lokasi'=>'Lokasi'] as $href=>$label)
                        <a href="{{ $href }}" style="font-size:0.85rem;color:rgba(255,255,255,0.45);text-decoration:none;" class="hover:text-emerald transition-colors">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:12px;">Info</p>
                    <div style="display:flex;flex-direction:column;gap:8px;font-size:0.85rem;">
                        <p>📍 Bojongnangka, Jawa Tengah</p>
                        <p>⏰ Setiap Hari, 07.00 – 18.00 WIB</p>
                    </div>
                </div>
            </div>

            <div style="border-top:1px solid rgba(255,255,255,0.07);padding-top:20px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:8px;">
                <p style="font-size:0.75rem;">© {{ date('Y') }} Wisata Gatra Kencana Bojongnangka. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Jalankan pengubah angka counter
        function adjustQty(fieldId, delta) {
            const input = document.getElementById(fieldId);
            let val = parseInt(input.value) || 0;
            val = Math.max(0, val + delta);
            input.value = val;
            calculateTotal();
        }

        // Kalkulasi live total belanjaan tiket booking publik
        function calculateTotal() {
            let total = 0;
            let totalQty = 0;
            
            const inputs = ['adult_qty', 'child_qty', 'terusan_qty'];
            inputs.forEach(id => {
                const el = document.getElementById(id);
                const qty = parseInt(el.value) || 0;
                const price = parseInt(el.dataset.price) || 0;
                total += qty * price;
                totalQty += qty;
            });

            document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total-qty').textContent = totalQty + ' Tiket';
        }

        // Generate format teks otomatis buat dilempar tembus langsung ke WA admin
        function sendToWhatsApp() {
            const name = document.getElementById('cust_name').value.trim();
            const phone = document.getElementById('cust_phone').value.trim();
            const date = document.getElementById('cust_date').value;
            
            const adult = parseInt(document.getElementById('adult_qty').value) || 0;
            const child = parseInt(document.getElementById('child_qty').value) || 0;
            const terusan = parseInt(document.getElementById('terusan_qty').value) || 0;

            // Validasi kelengkapan form
            if(!name || !phone || !date) {
                alert('Sumpah, diisi dulu Nama, No WA, dan Tanggal Kunjungannya ya, Cik! 😭');
                return;
            }
            if((adult + child + terusan) === 0) {
                alert('Isi minimal 1 jumlah tiket yang mau lo booking, Cik!');
                return;
            }

            // Hitung ulang total harga buat di text WA
            let priceAdult = parseInt(document.getElementById('adult_qty').dataset.price);
            let priceChild = parseInt(document.getElementById('child_qty').dataset.price);
            let priceTerusan = parseInt(document.getElementById('terusan_qty').dataset.price);
            let grantTotal = (adult * priceAdult) + (child * priceChild) + (terusan * priceTerusan);

            const modeLabel = "{{ $modeLabel }}";

            // Susun template string text WA sesuai format rapi request lo
            let message = `*BOOKING TIKET ONLINE GATRA KENCANA*\n\n`;
            message += `Nama Lengkap : ${name}\n`;
            message += `Nomor WhatsApp : ${phone}\n`;
            message += `Tanggal Booking : ${date}\n\n`;
            message += `-------Detail Tiket-------\n`;
            message += `Mode Harga : ${modeLabel}\n\n`;
            
            if(adult > 0) message += `- Dewasa : ${adult}x (Rp ${priceAdult.toLocaleString('id-ID')})\n`;
            if(child > 0) message += `- Anak : ${child}x (Rp ${priceChild.toLocaleString('id-ID')})\n`;
            if(terusan > 0) message += `🎫 Terusan : ${terusan}x (Rp ${priceTerusan.toLocaleString('id-ID')})\n`;
            
            message += `\n*TOTAL PEMBAYARAN: Rp ${grantTotal.toLocaleString('id-ID')}*`;
            message += `\n---------------------------\n`;
            message += `_Mohon diproses ya Admin, terima kasih!_`;

            // Menerima data dinamis nomor WhatsApp yang valid dari Controller
            const adminWA = "{{ $waNumber }}"; 
            
            // Redirect langsung buka aplikasi WhatsApp dengan teks utuh terformat
            const url = `https://wa.me/${adminWA}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        }
    </script>
</body>
</html>