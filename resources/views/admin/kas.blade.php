@extends('layouts.admin')

@section('title', 'Buku Kas')

@section('content')
<div class="p-4">

    <div class="mb-4">
        <h2 class="font-bold text-gray-900 text-xl">💰 Buku Kas Operasional</h2>
        <p class="text-gray-500 text-sm mt-0.5">Pencatatan Pemasukan & Pengeluaran</p>
    </div>

    {{-- Date Filter --}}
    <div class="bg-white rounded-xl shadow-sm p-3 mb-4 flex items-center gap-3">
        <label class="text-sm font-semibold text-gray-700">Tanggal:</label>
        <input type="date" value="{{ $date }}"
            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-400 outline-none"
            onchange="window.location.href='{{ route('admin.kas') }}?date=' + this.value">
    </div>

    {{-- Balance Summary --}}
    <div class="grid grid-cols-3 gap-2 mb-4">
        <div class="bg-green-100 rounded-xl p-3 text-center">
            <p class="text-green-700 text-xs font-semibold">Pemasukan</p>
            <p class="text-green-900 font-bold text-sm mt-0.5">{{ number_format($totalIn, 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-100 rounded-xl p-3 text-center">
            <p class="text-red-700 text-xs font-semibold">Pengeluaran</p>
            <p class="text-red-900 font-bold text-sm mt-0.5">{{ number_format($totalOut, 0, ',', '.') }}</p>
        </div>
        <div class="{{ $balance >= 0 ? 'bg-blue-100' : 'bg-orange-100' }} rounded-xl p-3 text-center">
            <p class="{{ $balance >= 0 ? 'text-blue-700' : 'text-orange-700' }} text-xs font-semibold">Saldo</p>
            <p class="{{ $balance >= 0 ? 'text-blue-900' : 'text-orange-900' }} font-bold text-sm mt-0.5">{{ number_format($balance, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Add Entry Form --}}
    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
        <h3 class="font-bold text-gray-800 text-sm mb-3">➕ Tambah Catatan Kas</h3>

        <form method="POST" action="{{ route('admin.kas.store') }}" class="space-y-3">
            @csrf

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis</label>
                    <div class="grid grid-cols-2 gap-1.5">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="in" class="sr-only peer" {{ old('type', 'in') === 'in' ? 'checked' : '' }}>
                            <div class="text-center border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-800 rounded-xl py-2 text-xs font-bold text-gray-500 transition-all">
                                ⬆ Masuk
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="out" class="sr-only peer" {{ old('type') === 'out' ? 'checked' : '' }}>
                            <div class="text-center border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-800 rounded-xl py-2 text-xs font-bold text-gray-500 transition-all">
                                ⬇ Keluar
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Keterangan</label>
                <input type="text" name="description" value="{{ old('description') }}" required
                    placeholder="Contoh: Pembelian tinta printer"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nominal (Rp)</label>
                <input type="number" name="amount" value="{{ old('amount') }}" required min="1"
                    placeholder="0"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
            </div>

            <button type="submit"
                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-xl text-sm transition-colors">
                💾 Simpan Catatan
            </button>
        </form>
    </div>

    {{-- Cashflow Ledger Table --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-sm">📒 Riwayat Kas</h3>
            <span class="text-xs text-gray-500">{{ $cashflows->count() }} entri</span>
        </div>

        @if($cashflows->isEmpty())
        <div class="text-center text-gray-400 py-10">
            <p class="text-3xl mb-2">📭</p>
            <p class="text-sm">Belum ada catatan kas pada tanggal ini</p>
        </div>
        @else
        <div class="divide-y divide-gray-100">
            @foreach($cashflows as $cf)
            <div class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-base
                        {{ $cf->type === 'in' ? 'bg-green-100' : 'bg-red-100' }}">
                        {{ $cf->type === 'in' ? '⬆' : '⬇' }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $cf->description }}</p>
                        <p class="text-xs text-gray-400">{{ $cf->created_at->setTimezone('Asia/Jakarta')->format('H:i') }} — {{ $cf->user->name ?? '-' }}</p>
                    </div>
                </div>
                <p class="font-bold text-sm {{ $cf->type === 'in' ? 'text-green-700' : 'text-red-700' }}">
                    {{ $cf->type === 'in' ? '+' : '-' }}Rp {{ number_format($cf->amount, 0, ',', '.') }}
                </p>
            </div>
            @endforeach
        </div>
        @endif
    </div>

{{-- ── Quick action row ── --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px;">
        <a href="{{ route('admin.rekapan') }}"
            style="display:flex;align-items:center;gap:10px;background:white;border:1px solid rgba(112,119,113,0.1);border-radius:14px;padding:14px;text-decoration:none;transition:all 0.2s;"
            onmouseover="this.style.borderColor='rgba(42,157,111,0.3)';this.style.transform='translateY(-2px)'"
            onmouseout="this.style.borderColor='rgba(112,119,113,0.1)';this.style.transform='translateY(0)'">
            <div style="width:36px;height:36px;background:rgba(42,157,111,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">📊</div>
            <div>
                <p style="font-size:0.8rem;font-weight:600;color:#1E2522;">Rekapan</p>
                <p style="font-size:0.7rem;color:#707771;">Laporan hari ini</p>
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
