<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kas Kelas</title>
    <link rel="shortcut icon" href="{{ asset('images/wallet.png') }}" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #e3e6f0; font-family: 'Inter', sans-serif; }
        .navbar { background-color: #ffffff !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .nav-link { color: #5a5c69 !important; font-weight: 600; }
        .nav-link.active { color: #4e73df !important; }
        .card { background-color: #ffffff; border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .icon-shape { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/dashboard">
                <i class="fas fa-wallet me-2"></i>KAS KELAS
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-start align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">Dashboard</a>
                    </li>

                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item"><a class="nav-link" href="/siswa">Data Siswa</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pemasukan">Pemasukan</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pengeluaran">Pengeluaran</a></li>
                    @endif
                    
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0 w-100 w-lg-auto">
                        <form action="/logout" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm px-4 rounded-pill w-100">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Dashboard Overview</h4>
                <p class="text-muted mb-0">Halo {{ auth()->user()->nama_lengkap }}, selamat datang kembali.</p>
            </div>
            <span class="badge {{ auth()->user()->role == 'admin' ? 'bg-primary' : 'bg-secondary' }} rounded-pill px-3 py-2">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

        <!-- TAMPILAN ADMIN -->
        @if(auth()->user()->role == 'admin')
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Total Saldo</span>
                            <div class="icon-shape bg-success bg-opacity-10 text-success"><i class="fas fa-wallet"></i></div>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Pemasukan</span>
                            <div class="icon-shape bg-primary bg-opacity-10 text-primary"><i class="fas fa-arrow-down"></i></div>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Pengeluaran</span>
                            <div class="icon-shape bg-danger bg-opacity-10 text-danger"><i class="fas fa-arrow-up"></i></div>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Siswa Aktif</span>
                            <div class="icon-shape bg-warning bg-opacity-10 text-warning"><i class="fas fa-users"></i></div>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">{{ $jumlahSiswa }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- TAMPILAN KHUSUS SISWA -->
        @if(auth()->user()->role == 'siswa')
        <div class="row mt-2">
            <!-- Kolom Kiri: Status -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-5">
                        <h5 class="text-muted mb-3">Status Iuran Kamu</h5>
                        
                        <!-- PERBAIKAN LOGIKA HITUNG (JALAN TIKUS) -->
                        @php
                            $target = 50000; 
                            // Kita panggil Model Pemasukan langsung, cari yang user_id nya SAMA dengan user login
                            // Dan hitung jumlah yang statusnya 'lunas'
                            $sudahBayar = \App\Models\Pemasukan::where('user_id', auth()->id())
                                            ->where('status', 'lunas')
                                            ->sum('jumlah');
                            
                            $kurang = $target - $sudahBayar;
                        @endphp

                        @if($kurang > 0)
                            <h2 class="text-danger fw-bold">Kurang Rp {{ number_format($kurang, 0, ',', '.') }}</h2>
                            <p class="text-muted">Ayo segera lunasi ya!</p>
                        @else
                            <h2 class="text-success fw-bold">LUNAS! 🎉</h2>
                            <p class="text-muted">Terima kasih sudah rajin menabung.</p>
                        @endif
                        
                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted">Total yang sudah di-ACC: <strong>Rp {{ number_format($sudahBayar, 0, ',', '.') }}</strong></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Upload Bukti -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold text-primary py-3">
                        <i class="fas fa-upload me-2"></i>Konfirmasi Pembayaran
                    </div>
                    <div class="card-body p-4">
                        <form action="/pemasukan/transfer" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="small fw-bold text-muted">Nominal Transfer (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">Rp</span>
                                    <input type="number" name="jumlah" class="form-control border-start-0 ps-0" placeholder="5000" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold text-muted">Tanggal Transfer</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold text-muted">Bukti Foto</label>
                                <input type="file" name="foto_bukti" class="form-control" accept="image/*" required>
                                <small class="text-muted" style="font-size: 0.75rem">*Format: JPG/PNG, Max 2MB</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold mt-2">
                                KIRIM BUKTI <i class="fas fa-paper-plane ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>