<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
   public function index()
    {
        // 1. Ambil data siswa + Hitung total pemasukannya otomatis
        $dataSiswa = User::where('role', 'siswa')
                    ->withSum('pemasukan', 'jumlah') // Fitur ajaib Laravel buat nge-sum
                    ->get();

        // 2. Hitung Target Pembayaran (Logika Minggu Berjalan)
        $tanggalMulai = '2025-11-01'; // <-- GANTI TANGGAL INI SESUAI KAPAN KAS DIMULAI
        $mingguBerjalan = floor(now()->diffInDays($tanggalMulai) / 7); // Hitung selisih minggu
        $wajibBayar = $mingguBerjalan * 5000; // 5.000 per minggu

        return view('siswa', compact('dataSiswa', 'wajibBayar'));
    }
}