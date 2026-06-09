<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::with('author')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.news.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.news.form', ['article' => null]);
    }

    public function store(Request $request)
    {
        // Validasi input disesuaikan dengan kebutuhan card landing page
        $request->validate([
            'title'          => 'required|string|max:255',
            'content'        => 'required|string|max:500', // Dibatasi agar pas jadi deskripsi pendek card
            'tag'            => 'required|string|max:60',
            'published_date' => 'required|date', // Pengganti emoji untuk tanggalan card
            'image'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Wajib upload gambar max 2MB
        ]);

        // Proses simpan file gambar ke storage/app/public/news
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        NewsArticle::create([
            'title'          => $request->title,
            'content'        => $request->input('content'),
            'tag'            => strtoupper($request->tag), // Otomatis kapital untuk label badge (EVENT, WAHANA)
            'published_date' => $request->published_date,
            'image'          => $imagePath,
            'is_published'   => $request->boolean('is_published', true),
            'author_id'      => Auth::id(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit(NewsArticle $article)
    {
        return view('admin.news.form', compact('article'));
    }

    public function update(Request $request, NewsArticle $article)
    {
        // Validasi edit (gambar diset nullable karena kalau ga upload berarti pakai gambar lama)
        $request->validate([
            'title'          => 'required|string|max:255',
            'content'        => 'required|string|max:500',
            'tag'            => 'required|string|max:60',
            'published_date' => 'required|date',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Jika user upload gambar baru pas edit, hapus gambar lama biar storage ga penuh
        if ($request->hasFile('image')) {
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $article->image = $request->file('image')->store('news', 'public');
        }

        $article->update([
            'title'          => $request->title,
            'content'        => $request->input('content'),
            'tag'            => strtoupper($request->tag),
            'published_date' => $request->published_date,
            'is_published'   => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(NewsArticle $article)
    {
        // Hapus file gambar dari storage saat data artikel dihapus
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }

    public function togglePublish(NewsArticle $article)
    {
        $article->update(['is_published' => !$article->is_published]);
        return back()->with('success', $article->is_published ? 'Artikel dipublikasikan.' : 'Artikel disembunyikan.');
    }
}