@extends('layouts.admin')

@section('title', '📊 Rekapan Bulanan')

@section('content')
<div class="p-4 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800">📊 Laporan Rekapan Bulanan</h2>
            <p class="text-sm text-gray-500">Periode Bulan: <span class="font-semibold text-green-700">{{ \Carbon\Carbon::parse($month.'-01')->translatedFormat('F Y') }}</span></p>
        </div>
        
        {{-- Filter & Export Form --}}
        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('admin.rekapan.bulanan') }}" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm border border-gray-200">
                <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()" class="text-sm font-semibold text-gray-700 p-1.5 outline-none focus:ring-2 focus:ring-green-400 rounded-lg">
            </form>
            <a href="{{ route('admin.rekapan.bulanan.export') }}?month={{ $month }}" class="bg-green-700 hover:bg-green-800 text-white font-bold px-4 py-2.5 rounded-xl text-sm flex items-center gap-2 transition-all shadow-md">
                📥 Export Excel
            </a>
        </div>
    </div>

    {{-- Ringkasan Kinerja Bulan Ini --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-green-800 to-green-900 text-white p-4 rounded-2xl shadow-md">
            <p class="text-green-200 text-xs uppercase tracking-wider">Total Pendapatan</p>
            <p class="text-2xl font-bold mt-1 tabular-nums">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow-sm">
            <p class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Total Pengunjung</p>
            <p class="text-2xl font-bold text-gray-800 mt-1 tabular-nums">{{ number_format($totalVisitors, 0, ',', '.') }} Orang</p>
        </div>
        <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow-sm">
            <p class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Rata-rata Transaksi / Hari</p>
            <p class="text-2xl font-bold text-gray-800 mt-1 tabular-nums">
                {{ $dailyStats->count() > 0 ? number_format($dailyStats->sum('trx') / $dailyStats->count(), 1, ',', '.') : 0 }} Trx
            </p>
        </div>
    </div>

    {{-- Breakdown Per Loket/Booth --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 mb-6">
        <h3 class="font-bold text-gray-800 text-base mb-4">🌿 Rincian Pendapatan Per Loket</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach(['loket_masuk' => ['🎟️ Loket Masuk', 'from-emerald-50 to-emerald-100', 'text-emerald-800'], 'kolam_renang' => ['🏊 Kolam Renang', 'from-blue-50 to-blue-100', 'text-blue-800'], 'kelinci' => ['🐰 Taman Kelinci', 'from-amber-50 to-amber-100', 'text-amber-800']] as $key => $meta)
                @php 
                    $boothData = $boothBreakdown->get($key); 
                @endphp
                <div class="bg-gradient-to-b {{ $meta[1] }} p-4 rounded-xl border border-black/5">
                    <p class="font-bold {{ $meta[2] }} text-sm">{{ $meta[0] }}</p>
                    <div class="mt-3 space-y-1">
                        <p class="text-xs text-gray-500 flex justify-between">Uang: <strong class="text-gray-700">Rp {{ number_format($boothData['revenue'] ?? 0, 0, ',', '.') }}</strong></p>
                        <p class="text-xs text-gray-500 flex justify-between">Pengunjung: <strong class="text-gray-700">{{ number_format($boothData['visitors'] ?? 0, 0, ',', '.') }} org</strong></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tabel Grafik Harian --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-800 text-base">📅 Grafik Rincian Harian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 font-semibold text-xs uppercase border-b border-gray-200">
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3 text-center">Transaksi</th>
                        <th class="px-5 py-3 text-center">Total Pengunjung</th>
                        <th class="px-5 py-3 text-right">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($dailyStats as $stat)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-5 py-3.5 font-medium text-gray-900">{{ $stat['date'] }}</td>
                            <td class="px-5 py-3.5 text-center tabular-nums">{{ $stat['trx'] }}</td>
                            <td class="px-5 py-3.5 text-center tabular-nums">{{ number_format($stat['visitors'], 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-right font-semibold text-green-700 tabular-nums">Rp {{ number_format($stat['revenue'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400 font-medium">Belum ada data transaksi di bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection