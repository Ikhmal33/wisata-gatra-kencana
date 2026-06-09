<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    protected $fillable = ['date','type','description','amount','user_id','booth_type'];
    protected $casts    = ['date'=>'date'];

    public function user() { return $this->belongsTo(User::class); }
}