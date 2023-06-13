<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RAB extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_trx',
        'penyusun',
        'tgl_rab',
        'total'
    ];

    public function detail()
    {
        return $this->hasMany(RABDetail::class, 'no_trx', 'no_trx');
    }

    public function getManager()
    {
        return $this->belongsTo(User::class, 'penyusun', 'id');
    }
}
