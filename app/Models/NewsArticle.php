<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    // KITA REGISTER KOLOM IMAGE DAN PUBLISHED_DATE DI SINI BIAR GA DIBLOKIR LARAVEL
    protected $fillable = [
        'title',
        'content',
        'tag',
        'image',
        'published_date',
        'is_published',
        'author_id'
    ];

    protected $casts = [
        'is_published'   => 'boolean',
        'published_date' => 'date'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->content), 120);
    }
}