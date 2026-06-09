@extends('layouts.admin')

@section('title', $article ? '📝 Edit Kabar Gatra' : '✍️ Tulis Kabar Baru')

@section('content')
<div class="p-4 max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.news.index') }}" class="text-xs text-green-700 hover:text-green-800 font-semibold flex items-center gap-1 mb-2">
            ← Kembali ke Daftar Berita
        </a>
        <h2 class="font-bold text-2xl text-gray-800">{{ $article ? '📝 Edit Kabar Gatra Kencana' : '✍️ Buat Kabar Gatra Kencana Baru' }}</h2>
        <p class="text-sm text-gray-500">Sesuaikan format konten agar rapi saat tampil di kartu website utama.</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <form method="POST" action="{{ $article ? route('admin.news.update', $article->id) : route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if($article)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Kategori / Tag --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Kategori / Tag</label>
                    <input type="text" name="tag" value="{{ old('tag', $article ? $article->tag : '') }}" required placeholder="Contoh: EVENT, FASILITAS, WAHANA"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                </div>
                
                {{-- Tanggal Rilis/Event --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Tanggal Rilis Konten</label>
                    <input type="date" name="published_date" value="{{ old('published_date', $article && $article->published_date ? \Carbon\Carbon::parse($article->published_date)->toDateString() : '') }}" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                </div>
            </div>

            {{-- Judul Artikel --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Judul Kabar / Berita</label>
                <input type="text" name="title" value="{{ old('title', $article ? $article->title : '') }}" required placeholder="Contoh: Edukasi Penanam Padi"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-gray-900 focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
            </div>

            {{-- Upload File Gambar --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Gambar Banner Terkini</label>
                @if($article && $article->image)
                    <div class="mb-2 max-w-xs overflow-hidden rounded-xl border border-gray-200">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="Pratinjau" class="w-full h-32 object-cover">
                    </div>
                @endif
                <input type="file" name="image" {{ $article ? '' : 'required' }} accept="image/*"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                <p class="text-[11px] text-gray-400 mt-1">* Format gambar direkomendasikan landscape (seperti pada landing page).</p>
            </div>

            {{-- Isi Konten Artikel --}}
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider">Isi Deskripsi Pendek</label>
                    <span class="text-[10px] text-gray-400 font-medium" id="char-count">Maks. 500 karakter</span>
                </div>
                <textarea name="content" required rows="5" maxlength="500" placeholder="Tuliskan 2-3 kalimat penjelasan ringkas biar muat di dalam box card, Cik..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none leading-relaxed">{{ old('content', $article->content ?? '') }}</textarea>
            </div>

            {{-- Submit Button --}}
            <button type="submit" 
                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-md mt-2">
                🚀 {{ $article ? 'Simpan Perubahan Kabar' : 'Terbitkan Kabar Sekarang' }}
            </button>
        </form>
    </div>
</div>
@endsection