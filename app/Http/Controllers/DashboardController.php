<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Data (Hanya yang LUNAS)
        // Tambahkan ->where('status', 'lunas') agar uang pending tidak ikut terhitung
        $totalPemasukan = Pemasukan::where('status', 'lunas')->sum('jumlah'); 
        
        $totalPengeluaran = Pengeluaran::sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;
        $jumlahSiswa = User::where('role', 'siswa')->count();

        // 2. Kirim data ke View
        return view('dashboard', compact('totalPemasukan', 'totalPengeluaran', 'saldo', 'jumlahSiswa'));
    }
}