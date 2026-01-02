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
        // 1. Hitung Data dulu
        $totalPemasukan = Pemasukan::sum('jumlah');
        $totalPengeluaran = Pengeluaran::sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;
        $jumlahSiswa = User::where('role', 'siswa')->count();

        // 2. Kirim data ke View (Bagian ini PENTING, jangan sampai hilang!)
        return view('dashboard', compact('totalPemasukan', 'totalPengeluaran', 'saldo', 'jumlahSiswa'));
    }
}