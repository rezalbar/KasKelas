<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

    // PERBAIKAN: Tambahkan 'foto_bukti' dan 'status'
    protected $fillable = [
    'user_id',
    'jumlah',
    'tanggal',
    'keterangan',
    'foto_bukti', // Pastikan ini ada
    'status',     // Pastikan ini ada
];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}