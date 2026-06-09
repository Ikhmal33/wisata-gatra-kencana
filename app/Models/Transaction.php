<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_number','user_id','booth_type','pricing_mode',
        'adult_qty','child_qty','terusan_qty',
        'total_price','payment_method',
        'cash_received','cash_change','transaction_date',
    ];
    protected $casts = ['transaction_date'=>'date'];

    public function user() { return $this->belongsTo(User::class); }

    public function getBoothLabelAttribute(): string
    {
        return match($this->booth_type) {
            'loket_masuk'  => 'Loket Masuk',
            'kolam_renang' => 'Loket Kolam Renang',
            'kelinci'      => 'Loket Kelinci',
            default        => '-',
        };
    }

    public function getTotalVisitorsAttribute(): int
    {
        return $this->adult_qty + $this->child_qty + $this->terusan_qty;
    }

    public static function generateNumber(): string
    {
        $date = now()->format('Ymd');
        $last = self::whereDate('created_at', today())->count() + 1;
        return 'TRX-'.$date.'-'.str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}