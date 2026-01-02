<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        // Simpan ke database
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa' // Otomatis jadi siswa
        ]);

        // Balikin ke halaman login
        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}