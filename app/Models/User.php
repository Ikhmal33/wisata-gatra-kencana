<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name','username','password','role','assigned_booth'];
    protected $hidden   = ['password','remember_token'];

    public function transactions() { return $this->hasMany(Transaction::class); }
    public function cashflows()    { return $this->hasMany(Cashflow::class); }
    public function news()         { return $this->hasMany(NewsArticle::class,'author_id'); }

   // public function getAuthIdentifierName(): string { return 'username'; }

   public function isAdmin(): bool        { return $this->role === 'administrator'; } // <-- Diubah jadi administrator
    public function isCashier(): bool      { return $this->role === 'cashier'; }
    public function isContentAdmin(): bool { return $this->role === 'tejo'; } // <-- Diubah jadi tejo sesuai isi db lo
    public function hasFinanceAccess(): bool { return in_array($this->role,['administrator','cashier']); } // <-- Diubah jadi administrator

    public function getBoothLabelAttribute(): string
    {
        return match($this->assigned_booth) {
            'loket_masuk'  => 'Loket Masuk',
            'kolam_renang' => 'Loket Kolam Renang',
            'kelinci'      => 'Loket Kelinci',
            default        => ($this->role === 'admin') ? 'Super Admin' : 'Content Admin',
        };
    }
}