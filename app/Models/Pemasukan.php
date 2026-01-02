<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

    // 👇 TAMBAHKAN 'foto_bukti' DAN 'status' DI SINI 👇
    protected $fillable = [
        'user_id',
        'jumlah',
        'tanggal',
        'keterangan',
        'foto_bukti', // <-- Penting buat upload
        'status',     // <-- Penting buat pending/lunas
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}