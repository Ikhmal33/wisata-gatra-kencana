@extends('layouts.admin')

@section('title', 'Rekapan Harian')

@section('content')
<div class="p-4">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-bold text-gray-900 text-xl">📊 Rekapan Harian</h2>
            <p class="text-gray-500 text-sm mt-0.5">Semua Loket — Terpusat</p>
        </div>
        <a href="{{ route('admin.rekapan.export', ['date' => $date]) }}"
            class="bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-green-800 transition-colors flex items-center gap-2 shadow">
            📥 Export Excel
        </a>
    </div>

    {{-- Date Filter --}}
    <div class="bg-white rounded-xl shadow-sm p-3 mb-4 flex items-center gap-3">
        <label class="text-sm font-semibold text-gray-700">Tanggal:</label>
        <input type="date" id="date-filter" value="{{ $date }}"
            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-400 outline-none"
            onchange="window.location.href='{{ route('admin.rekapan') }}?date=' + this.value">
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 gap-3 mb-4">
        <div class="bg-green-700 text-white rounded-2xl p-4 shadow-md">
            <p class="text-green-200 text-xs uppercase tracking-wide">Total Pengunjung</p>
            <p class="text-3xl font-bold mt-1">{{ number_format($totalVisitors) }}</p>
            <p class="text-green-300 text-xs mt-1">orang</p>
        </div>
        <div class="bg-blue-700 text-white rounded-2xl p-4 shadow-md">
            <p class="text-blue-200 text-xs uppercase tracking-wide">Total Pendapatan</p>
            <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-blue-300 text-xs mt-1">{{ $transactions->count() }} transaksi</p>
        </div>
    </div>

    {{-- Booth Breakdown --}}
    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
        <h3 class="font-bold text-gray-800 text-sm mb-3">📍 Per Loket</h3>
        @php
            $boothLabels = ['loket_masuk' => 'Loket Masuk', 'kolam_renang' => 'Loket Kolam Renang', 'kelinci' => 'Loket Kelinci'];
            $boothColors = ['loket_masuk' => 'bg-green-100 text-green-800', 'kolam_renang' => 'bg-blue-100 text-blue-800', 'kelinci' => 'bg-orange-100 text-orange-800'];
        @endphp
        <div class="space-y-2">
            @foreach($boothLabels as $key => $label)
            <div class="flex items-center justify-between px-3 py-2.5 rounded-xl {{ $boothColors[$key] }}">
                <div>
                    <p class="font-semibold text-sm">{{ $label }}</p>
                    <p class="text-xs opacity-75">{{ $boothBreakdown[$key]['visitors'] ?? 0 }} pengunjung</p>
                </div>
                <p class="font-bold text-sm">Rp {{ number_format($boothBreakdown[$key]['revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Payment Method Breakdown --}}
    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
        <h3 class="font-bold text-gray-800 text-sm mb-3">💳 Metode Pembayaran</h3>
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-green-50 rounded-xl p-3 text-center">
                <p class="text-2xl">💵</p>
                <p class="font-bold text-green-800 text-sm">CASH</p>
                <p class="text-xs text-green-600 mt-0.5">{{ $paymentBreakdown['cash']['count'] ?? 0 }} transaksi</p>
                <p class="font-semibold text-green-900 text-sm mt-1">Rp {{ number_format($paymentBreakdown['cash']['revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-blue-50 rounded-xl p-3 text-center">
                <p class="text-2xl">📱</p>
                <p class="font-bold text-blue-800 text-sm">QRIS</p>
                <p class="text-xs text-blue-600 mt-0.5">{{ $paymentBreakdown['qris']['count'] ?? 0 }} transaksi</p>
                <p class="font-semibold text-blue-900 text-sm mt-1">Rp {{ number_format($paymentBreakdown['qris']['revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Transaction Table --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-4">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-sm">📋 Detail Transaksi</h3>
            <span class="text-xs text-gray-500">{{ $transactions->count() }} data</span>
        </div>

        @if($transactions->isEmpty())
        <div class="text-center text-gray-400 py-12">
            <p class="text-3xl mb-2">📭</p>
            <p class="text-sm">Belum ada transaksi pada tanggal ini</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide">
                    <tr>
                        <th class="px-3 py-2 text-left">No. Trx</th>
                        <th class="px-3 py-2 text-left">Waktu</th>
                        <th class="px-3 py-2 text-left">Loket</th>
                        <th class="px-3 py-2 text-left">Kasir</th>
                        <th class="px-3 py-2 text-right">D/A/T</th>
                        <th class="px-3 py-2 text-right">Total</th>
                        <th class="px-3 py-2 text-center">Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transactions as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-3 py-2.5 font-mono text-gray-700">{{ $trx->transaction_number }}</td>
                        <td class="px-3 py-2.5 text-gray-600">{{ $trx->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}</td>
                        <td class="px-3 py-2.5">
                            <span class="px-1.5 py-0.5 rounded-md text-xs font-medium
                                {{ $trx->booth_type === 'loket_masuk' ? 'bg-green-100 text-green-700' : ($trx->booth_type === 'kolam_renang' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700') }}">
                                {{ $trx->booth_label }}
                            </span>
                        </td>
                        <td class="px-3 py-2.5 text-gray-700">{{ $trx->user->name }}</td>
                        <td class="px-3 py-2.5 text-right text-gray-700">{{ $trx->adult_qty }}/{{ $trx->child_qty }}/{{ $trx->terusan_qty }}</td>
                        <td class="px-3 py-2.5 text-right font-semibold text-gray-900">{{ number_format($trx->total_price, 0, ',', '.') }}</td>
                        <td class="px-3 py-2.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold
                                {{ $trx->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ strtoupper($trx->payment_method) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

{{-- ── Quick action row ── --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px;">
        <a href="{{ route('admin.kas') }}"
            style="display:flex;align-items:center;gap:10px;background:white;border:1px solid rgba(112,119,113,0.1);border-radius:14px;padding:14px;text-decoration:none;transition:all 0.2s;"
            onmouseover="this.style.borderColor='rgba(234,168,58,0.4)';this.style.transform='translateY(-2px)'"
            onmouseout="this.style.borderColor='rgba(112,119,113,0.1)';this.style.transform='translateY(0)'">
            <div style="width:36px;height:36px;background:rgba(234,168,58,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">💰</div>
            <div>
                <p style="font-size:0.8rem;font-weight:600;color:#1E2522;">Buku Kas</p>
                <p style="font-size:0.7rem;color:#707771;">Catat pengeluaran</p>
            </div>
        </a>
        <a href="{{ route('admin.dashboard') }}"
            style="display:flex;align-items:center;gap:10px;background:white;border:1px solid rgba(112,119,113,0.1);border-radius:14px;padding:14px;text-decoration:none;transition:all 0.2s;"
            onmouseover="this.style.borderColor='rgba(234,168,58,0.4)';this.style.transform='translateY(-2px)'"
            onmouseout="this.style.borderColor='rgba(112,119,113,0.1)';this.style.transform='translateY(0)'">
            <div style="width:36px;height:36px;background:rgba(234,168,58,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">🎟️</div>
            <div>
                <p style="font-size:0.8rem;font-weight:600;color:#1E2522;">Tiket</p>
                <p style="font-size:0.7rem;color:#707771;">Penjualan Tiket</p>
            </div>
        </a>
    </div>

</div>
@endsection
