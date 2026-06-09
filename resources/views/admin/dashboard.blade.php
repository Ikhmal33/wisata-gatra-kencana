@extends('layouts.admin')

@section('title', $isLebaran ? '🌙 Mode Lebaran' : 'POS — Jual Tiket')

@section('content')
<div class="p-4 max-w-xl mx-auto lg:max-w-2xl">

    {{-- ── Banner Mode Lebaran (Otomatis Muncul Jika Aktif) ── --}}
    @if($isLebaran)
    <div class="bg-gradient-to-r from-orange-800 to-orange-700 text-white rounded-2xl p-4 mb-4 shadow-lg flex items-center gap-3 animate-pulse">
        <span class="text-2xl">🌙</span>
        <div>
            <p class="font-bold text-sm">Mode Lebaran Aktif</p>
            <p class="text-orange-200 text-xs mt-0.5">Tarif flat Rp 10.000 berlaku. Tiket terusan dinonaktifkan sementara.</p>
        </div>
    </div>
    @endif

    {{-- ── Header: Tanggal & Hari ── --}}
    <div class="bg-gradient-to-br from-green-800 to-green-900 text-white rounded-2xl p-4 mb-4 shadow-lg">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-green-300 text-xs uppercase tracking-widest mb-1">Selamat Datang,</p>
                <h2 class="font-bold text-xl">{{ $user->name }}</h2>
                <p class="text-green-200 text-sm">{{ $user->booth_label }}</p>
            </div>
            <div class="text-right">
                <p id="live-time" class="text-2xl font-bold tabular-nums text-white">--:--:--</p>
                <p class="text-green-300 text-xs id-date" id="live-date">—</p>
                <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full font-semibold
                    @if($isLebaran) bg-red-500 text-white
                    @elseif($isHoliday) bg-yellow-400 text-yellow-900
                    @else bg-green-500 text-white @endif">
                    @if($isLebaran) 🌙 Mode Lebaran @elseif($isHoliday) 🌟 Weekend / Hari Libur @else 📅 Hari Kerja @endif
                </span>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-green-700 grid grid-cols-2 gap-3 text-center">
            <div>
                <p class="text-green-300 text-xs">Transaksi Hari Ini</p>
                <p class="text-white font-bold text-lg">{{ $todayStats->trx_count ?? 0 }}</p>
            </div>
            <div>
                <p class="text-green-300 text-xs">Total Pendapatan</p>
                <p class="text-white font-bold text-lg">Rp {{ number_format($todayStats->total_revenue ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- ── POS Form ── --}}
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="bg-green-50 border-b border-green-100 px-4 py-3">
            <h3 class="font-bold text-green-900 text-base">🎟️ Penjualan Tiket</h3>
            <p class="text-green-600 text-xs mt-0.5">{{ $user->booth_label }}</p>
        </div>

        <form id="pos-form" action="{{ route('admin.ticket.store') }}" method="POST" class="p-4 space-y-4">
            @csrf
            <input type="hidden" name="booth_type" value="{{ $user->assigned_booth }}">
            <input type="hidden" name="pricing_mode" value="{{ $isLebaran ? 'lebaran' : 'normal' }}">

            {{-- Harga berlaku --}}
            <div class="bg-gray-50 rounded-xl p-3 text-xs text-gray-600 flex flex-wrap gap-3">
                <div>
                    <span class="font-semibold text-gray-800">Harga Berlaku:</span>
                </div>
                @if($user->assigned_booth === 'loket_masuk')
                <div class="flex gap-3">
                    <span>Dewasa: <strong class="text-green-700">Rp {{ number_format($prices['adult'], 0, ',', '.') }}</strong></span>
                    <span>Anak: <strong class="text-green-700">Rp {{ number_format($prices['child'], 0, ',', '.') }}</strong></span>
                    @if(!$isLebaran)
                    <span>Terusan: <strong class="text-green-700">Rp {{ number_format($prices['terusan'], 0, ',', '.') }}</strong></span>
                    @endif
                </div>
                @else
                <div>
                    <span>Harga: <strong class="text-green-700">Rp {{ number_format($prices['adult'], 0, ',', '.') }}</strong> / orang</span>
                </div>
                @endif
            </div>

            {{-- Ticket Qty Controls ── --}}
            @if($user->assigned_booth === 'loket_masuk')
            <div class="grid grid-cols-1 gap-3">
                {{-- Row Dewasa --}}
                <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">👨 Dewasa</p>
                        <p class="text-xs text-gray-500">Rp {{ number_format($prices['adult'], 0, ',', '.') }} / tiket</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="adjustQty('adult_qty', -1)" class="w-9 h-9 rounded-full bg-red-100 text-red-700 font-bold text-xl flex items-center justify-center hover:bg-red-200 transition-colors">−</button>
                        <input type="number" name="adult_qty" id="adult_qty" value="0" min="0" max="999" data-price="{{ $prices['adult'] }}" oninput="recalcTotal()" class="w-14 text-center border border-gray-300 rounded-lg py-1.5 text-lg font-bold text-gray-800 focus:ring-2 focus:ring-green-400 outline-none">
                        <button type="button" onclick="adjustQty('adult_qty', 1)" class="w-9 h-9 rounded-full bg-green-100 text-green-700 font-bold text-xl flex items-center justify-center hover:bg-green-200 transition-colors">+</button>
                    </div>
                </div>

                {{-- Row Anak-Anak --}}
                <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">👦 Anak-Anak</p>
                        <p class="text-xs text-gray-500">Rp {{ number_format($prices['child'], 0, ',', '.') }} / tiket</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="adjustQty('child_qty', -1)" class="w-9 h-9 rounded-full bg-red-100 text-red-700 font-bold text-xl flex items-center justify-center hover:bg-red-200 transition-colors">−</button>
                        <input type="number" name="child_qty" id="child_qty" value="0" min="0" max="999" data-price="{{ $prices['child'] }}" oninput="recalcTotal()" class="w-14 text-center border border-gray-300 rounded-lg py-1.5 text-lg font-bold text-gray-800 focus:ring-2 focus:ring-green-400 outline-none">
                        <button type="button" onclick="adjustQty('child_qty', 1)" class="w-9 h-9 rounded-full bg-green-100 text-green-700 font-bold text-xl flex items-center justify-center hover:bg-green-200 transition-colors">+</button>
                    </div>
                </div>

                {{-- Row Terusan (Disembunyikan saat Lebaran) --}}
                @if(!$isLebaran)
                <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">🎫 Terusan</p>
                        <p class="text-xs text-gray-500">Rp {{ number_format($prices['terusan'], 0, ',', '.') }} / tiket</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="adjustQty('terusan_qty', -1)" class="w-9 h-9 rounded-full bg-red-100 text-red-700 font-bold text-xl flex items-center justify-center hover:bg-red-200 transition-colors">−</button>
                        <input type="number" name="terusan_qty" id="terusan_qty" value="0" min="0" max="999" data-price="{{ $prices['terusan'] }}" oninput="recalcTotal()" class="w-14 text-center border border-gray-300 rounded-lg py-1.5 text-lg font-bold text-gray-800 focus:ring-2 focus:ring-green-400 outline-none">
                        <button type="button" onclick="adjustQty('terusan_qty', 1)" class="w-9 h-9 rounded-full bg-green-100 text-green-700 font-bold text-xl flex items-center justify-center hover:bg-green-200 transition-colors">+</button>
                    </div>
                </div>
                @else
                <input type="hidden" name="terusan_qty" value="0">
                @endif
            </div>
            @else
            {{-- Loket Kolam / Kelinci --}}
            <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                <div>
                    <p class="font-semibold text-gray-800 text-sm">🎟️ Jumlah Tiket</p>
                    <p class="text-xs text-gray-500">Rp {{ number_format($prices['adult'], 0, ',', '.') }} / orang</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="adjustQty('adult_qty', -1)" class="w-9 h-9 rounded-full bg-red-100 text-red-700 font-bold text-xl flex items-center justify-center hover:bg-red-200 transition-colors">−</button>
                    <input type="number" name="adult_qty" id="adult_qty" value="0" min="0" max="999" data-price="{{ $prices['adult'] }}" oninput="recalcTotal()" class="w-14 text-center border border-gray-300 rounded-lg py-1.5 text-lg font-bold text-gray-800 focus:ring-2 focus:ring-green-400 outline-none">
                    <button type="button" onclick="adjustQty('adult_qty', 1)" class="w-9 h-9 rounded-full bg-green-100 text-green-700 font-bold text-xl flex items-center justify-center hover:bg-green-200 transition-colors">+</button>
                </div>
            </div>
            <input type="hidden" name="child_qty" value="0">
            <input type="hidden" name="terusan_qty" value="0">
            @endif

            {{-- Total Price Display --}}
            <div class="rounded-xl px-4 py-3 flex items-center justify-between shadow-inner transition-colors duration-200 {{ $isLebaran ? 'bg-orange-800 text-white' : 'bg-green-700 text-white' }}">
                <span class="font-semibold text-sm">Total Pembayaran</span>
                <span id="total-display" class="text-2xl font-bold tabular-nums">Rp 0</span>
                <input type="hidden" name="total_price" id="total_price" value="0">
            </div>

            {{-- Payment Method Toggle --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="cash" class="sr-only peer" checked onchange="toggleCashSection(true)">
                        <div class="flex items-center justify-center gap-2 border-2 border-gray-200 peer-checked:border-green-600 peer-checked:bg-green-50 peer-checked:text-green-800 rounded-xl py-3 text-sm font-semibold text-gray-500 transition-all">
                            💵 CASH
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="qris" class="sr-only peer" onchange="toggleCashSection(false)">
                        <div class="flex items-center justify-center gap-2 border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-800 rounded-xl py-3 text-sm font-semibold text-gray-500 transition-all">
                            📱 QRIS
                        </div>
                    </label>
                </div>
            </div>

            {{-- Cash Calculator --}}
            <div id="cash-section" class="space-y-2">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Uang Diterima (Rp)</label>
                    <input type="number" name="cash_received" id="cash_received" oninput="calcChange()" placeholder="0" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg font-bold text-gray-800 focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 flex items-center justify-between">
                    <span class="text-sm font-semibold text-blue-700">Kembalian</span>
                    <span id="change-display" class="text-xl font-bold text-blue-800">Rp 0</span>
                    <input type="hidden" name="cash_change" id="cash_change" value="0">
                </div>
            </div>

            {{-- Submit / Print Button --}}
            <button type="submit" id="print-btn" class="w-full font-bold py-4 rounded-2xl text-base flex items-center justify-center gap-2 transition-all shadow-lg mt-2 text-white {{ $isLebaran ? 'bg-orange-700 hover:bg-orange-800' : 'bg-green-700 hover:bg-green-800' }}">
                🖨️ {{ $isLebaran ? 'Cetak Tiket Lebaran & Simpan' : 'Cetak Tiket & Simpan' }}
            </button>
        </form>
    </div>

    {{-- Quick links --}}
    <div class="grid grid-cols-2 gap-3 mt-4">
        <a href="{{ route('admin.rekapan') }}" class="bg-white rounded-xl p-3 text-center shadow-sm hover:shadow-md transition-shadow">
            <p class="text-2xl">📊</p>
            <p class="text-xs font-semibold text-gray-700 mt-1">Rekapan Hari Ini</p>
        </a>
        <a href="{{ route('admin.kas') }}" class="bg-white rounded-xl p-3 text-center shadow-sm hover:shadow-md transition-shadow">
            <p class="text-2xl">💰</p>
            <p class="text-xs font-semibold text-gray-700 mt-1">Buku Kas</p>
        </a>
    </div>
</div>

{{-- ── PRINT MODAL ── --}}
<div id="print-modal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xs overflow-hidden">
        <div class="p-5">
            <h3 class="font-bold text-center text-lg mb-4 text-gray-800">🎟️ Tiket Berhasil</h3>
            <div id="ticket-receipt" class="font-mono text-xs bg-gray-50 rounded-xl p-4 mb-4 leading-relaxed overflow-x-auto whitespace-pre"></div>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="printReceipt()" class="bg-green-700 text-white rounded-xl py-3 text-sm font-bold hover:bg-green-800 transition-colors">🖨️ Print</button>
                <button onclick="closeModal()" class="bg-gray-200 text-gray-700 rounded-xl py-3 text-sm font-bold hover:bg-gray-300 transition-colors">✅ Selesai</button>
            </div>
        </div>
    </div>
</div>

{{-- ── PRINT IFRAME (Sistem Bawaan Lo yang Stabil) ── --}}
@endsection

@push('scripts')
<script>
    // ── Live Clock With Seconds ──
    function updateClock() {
        const now = new Date();
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
        
        const hh = String(now.getHours()).padStart(2, '0');
        const mm = String(now.getMinutes()).padStart(2, '0');
        const ss = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('live-time').textContent = `${hh}:${mm}:${ss}`;
        document.getElementById('live-date').textContent = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ── Qty Adjuster ──
    function adjustQty(field, delta) {
        const el = document.getElementById(field);
        if (!el) return;
        let val = parseInt(el.value) || 0;
        val = Math.max(0, val + delta);
        el.value = val;
        recalcTotal();
    }

    // ── Total Recalculation ──
    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('input[data-price]').forEach(el => {
            const qty   = parseInt(el.value) || 0;
            const price = parseInt(el.dataset.price) || 0;
            total += qty * price;
        });
        document.getElementById('total_price').value = total;
        document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
        calcChange();
    }

    // ── Change Calculator ──
    function calcChange() {
        const total    = parseInt(document.getElementById('total_price').value) || 0;
        const received = parseInt(document.getElementById('cash_received').value) || 0;
        const change   = received - total;
        document.getElementById('cash_change').value = change;
        const el = document.getElementById('change-display');
        el.textContent = 'Rp ' + Math.max(0, change).toLocaleString('id-ID');
        el.className = change < 0 && received > 0
            ? 'text-xl font-bold text-red-600'
            : 'text-xl font-bold text-blue-800';
    }

    // ── Toggle Cash Section ──
    function toggleCashSection(isCash) {
        document.getElementById('cash-section').style.display = isCash ? '' : 'none';
        if(!isCash) {
            document.getElementById('cash_received').value = '';
            document.getElementById('cash_change').value = 0;
            document.getElementById('change-display').textContent = 'Rp 0';
        }
    }

    // ── Form Intercept → AJAX → Print Modal ──
    document.getElementById('pos-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const total = parseInt(document.getElementById('total_price').value) || 0;
        if(total === 0) { alert('Jumlah tiket belum diisi!'); return; }
        
        const isCash = document.querySelector('input[name="payment_method"]:checked').value === 'cash';
        if(isCash) {
            const received = parseInt(document.getElementById('cash_received').value) || 0;
            if(received > 0 && received < total) { alert('Uang diterima kurang dari total pembayaran!'); return; }
        }

        const btn = document.getElementById('print-btn');
        btn.disabled = true;
        btn.textContent = '⏳ Memproses...';

        try {
            const res = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: new FormData(this),
            });

            const data = await res.json();

            if (data.success) {
                showPrintModal(data.print_data);
                resetForm();
            } else {
                alert(data.message || 'Terjadi kesalahan. Silahkan coba lagi.');
            }
        } catch (err) {
            console.error(err);
            alert('Koneksi bermasalah.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '🖨️ Cetak Tiket & Simpan';
        }
    });

    function resetForm() {
        document.querySelectorAll('input[data-price]').forEach(el => el.value = 0);
        document.getElementById('cash_received').value = '';
        document.getElementById('cash_change').value = 0;
        document.getElementById('change-display').textContent = 'Rp 0';
        recalcTotal();
    }

    // ── Print Modal ──
    let currentPrintData = null;

    function showPrintModal(data) {
        currentPrintData = data;
        document.getElementById('ticket-receipt').textContent = buildReceiptText(data);
        document.getElementById('print-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('print-modal').classList.add('hidden');
    }

    // Format Struk Teks Murni (Aman untuk Printer Thermal 58mm)
    function buildReceiptText(d) {
        const W = 32;
        const rp = n => 'Rp' + parseInt(n).toLocaleString('id-ID');
        const c = s => ' '.repeat(Math.max(0, Math.floor((W - s.length) / 2))) + s;
        const lr = (l, r) => l + ' '.repeat(Math.max(1, W - l.length - r.length)) + r;
        const H = '--------------------------------';
        const HH = '================================';

        let lines = [
            c('WISATA GATRA KENCANA'),
            c('Bojongnangka, Pemalang'),
            HH,
            lr('No:', d.no),
            lr('Tgl:', d.date),
            lr('Kasir:', d.cashier),
            lr('Loket:', d.booth),
            H,
            c('-- RINCIAN TIKET --'),
            H
        ];

        if (d.adult_qty > 0)   lines.push(lr('Dewasa   x' + d.adult_qty, rp(d.adult_price * d.adult_qty)));
        if (d.child_qty > 0)   lines.push(lr('Anak     x' + d.child_qty, rp(d.child_price * d.child_qty)));
        if (d.terusan_qty > 0) lines.push(lr('Terusan  x' + d.terusan_qty, rp(d.terusan_price * d.terusan_qty)));

        lines.push(H);
        lines.push(lr('TOTAL', rp(d.total_price)));
        lines.push(H);
        lines.push(lr('Metode', d.payment_method));

        if (d.payment_method === 'CASH') {
            lines.push(lr('Diterima', rp(d.cash_received)));
            lines.push(lr('Kembalian', rp(Math.max(0, d.cash_change))));
        }

        lines.push(HH);
        lines.push(c('Terima kasih!'));
        lines.push(c('Selamat menikmati wisata'));
        return lines.join('\n');
    }

    // ── Thermal Print via Iframe - PERFECT CALIBRATION FOR 58mm (FIX KEPOTONG) ──
    function printReceipt() {
        if (!currentPrintData) return;
        
        // 1. Ambil teks murni dari generator struk bawaan lo
        const receiptText = buildReceiptText(currentPrintData);

        // 2. Bikin elemen iframe gaib di latar belakang
        const iframe = document.createElement('iframe');
        iframe.style.position = 'fixed';
        iframe.style.bottom = '0';
        iframe.style.right = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = '0';
        document.body.appendChild(iframe);

        // 3. Tulis dokumen HTML khusus struk dengan pembungkus <pre> aman
        const doc = iframe.contentWindow.document;
        doc.open();
        doc.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Cetak Tiket Gatra Kencana</title>
                <style>
                    @page {
                        size: 58mm auto;
                        margin: 0; /* Menghilangkan margin bawaan browser */
                    }
                    html, body {
                        margin: 0;
                        padding: 0;
                        background: white;
                        color: black;
                    }
                    pre {
                        font-family: 'Courier New', Courier, monospace;
                        font-size: 8.5pt; /* Ukuran pas agar karakter kanan tidak tergunting */
                        font-weight: bold;
                        width: 44mm; /* Lebar aman area teks agar pas di tengah roll kertas */
                        margin: 0;
                        padding: 4mm 3mm; /* Memberikan padding agar seimbang di tengah roll */
                        white-space: pre-wrap; /* Jaga kerapian spasi dan baris */
                        line-height: 1.3;
                    }
                </style>
            </head>
            <body><pre>${receiptText}</pre></body>
            </html>
        `);
        doc.close();

        // 4. Picu pencetakan otomatis setelah dom iframe siap
        setTimeout(() => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
            
            // 5. Hapus sampah iframe setelah dialog cetak selesai/ditutup kasir
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 1000);
        }, 300);
    }
</script>
@endpush