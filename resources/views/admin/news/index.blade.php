@extends('layouts.admin')

@section('title', '📰 Kelola Berita Publik')

@section('content')
<div class="p-4 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800">📰 Manajemen Berita & Artikel</h2>
            <p class="text-sm text-gray-500">Kelola konten informasi publik Wisata Gatra Kencana.</p>
        </div>
        <div>
            <a href="{{ route('admin.news.create') }}" class="bg-green-700 hover:bg-green-800 text-white font-bold px-4 py-2.5 rounded-xl text-sm flex items-center gap-2 transition-all shadow-md">
                ➕ Tulis Artikel Baru
            </a>
        </div>
    </div>

    {{-- Daftar Artikel --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-base">📚 Semua Artikel ({{ $articles->count() }})</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 font-semibold text-xs uppercase border-b border-gray-200">
                        <th class="px-5 py-3 w-16 text-center">Emoji</th>
                        <th class="px-5 py-3">Judul Artikel</th>
                        <th class="px-5 py-3">Kategori / Tag</th>
                        <th class="px-5 py-3">Penulis</th>
                        <th class="px-5 py-3">Tanggal Rilis</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-5 py-4 text-center text-2xl bg-gray-50/50">{{ $article->emoji ?? '📰' }}</td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900 text-sm hover:text-green-700 transition-colors">{{ $article->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit(strip_tags($article->content), 60) }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-block bg-green-50 text-green-700 border border-green-200 text-xs px-2.5 py-1 rounded-full font-medium">
                                    🏷️ {{ $article->tag }}
                                </span>
                            </td>
                            <td class="px-5 py-4 font-medium text-gray-800 text-xs">
                                👤 {{ $article->author->name ?? $article->user->name ?? 'Anonim' }}
                            </td>
                            <td class="px-5 py-4 text-xs text-gray-500 tabular-nums">
                                📅 {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.news.edit', $article->id) }}" class="bg-amber-100 hover:bg-amber-200 text-amber-800 p-2 rounded-lg text-xs font-semibold transition-colors">
                                        ✏️ Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.news.destroy', $article->id) }}" onsubmit="return confirm('Apakah lo yakin mau menghapus artikel ini, Cik?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-800 p-2 rounded-lg text-xs font-semibold transition-colors">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-gray-400 font-medium">
                                <p class="text-3xl mb-2">📭</p>
                                <p class="text-sm">Belum ada artikel berita yang ditulis. Lapak Tejo masih kosong!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection