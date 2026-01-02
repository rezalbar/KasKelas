<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kas</title>
    <link rel="shortcut icon" href="{{ asset('images/wallet.jpeg') }}" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            /* Background Gradient Miring biar modern */
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .card-login {
            width: 400px;
            border: none;
            border-radius: 20px; /* Sudut tumpul */
            box-shadow: 0 15px 35px rgba(0,0,0,0.2); /* Bayangan tebal */
            overflow: hidden;
            background: white;
        }
        .card-header-custom {
            background-color: #f8f9fc;
            padding: 40px 20px 20px;
            text-align: center;
            border-bottom: 1px solid #edf2f9;
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            background: #e8f0fe;
            color: #4e73df;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 15px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #d1d3e2;
            font-size: 0.95rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.25);
            border-color: #4e73df;
        }
        .btn-login {
            background: #4e73df;
            border: none;
            border-radius: 50px; /* Tombol lonjong */
            padding: 12px;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }
        .input-group-text {
            background: #f8f9fc;
            border: 1px solid #d1d3e2;
            border-radius: 10px 0 0 10px;
            color: #6c757d;
        }
        .input-with-icon {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>

<div class="card-login animate__animated animate__fadeInUp">
    <div class="card-header-custom">
        <div class="icon-circle">
            <i class="fas fa-wallet"></i>
        </div>
        <h4 class="fw-bold text-dark">KUANGAN KAS</h4>
        <p class="text-muted small mb-0">Silakan login untuk mengelola keuangan</p>
    </div>

    <div class="card-body p-4">
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div class="small">{{ session('error') }}</div>
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary ms-1">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control input-with-icon" placeholder="Masukkan username..." required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary ms-1">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control input-with-icon" placeholder="Masukkan password..." required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-login mb-3">
                MASUK <i class="fas fa-arrow-right ms-2"></i>
            </button>
            <div class="text-center mt-3">
    <small class="text-muted">Belum punya akun? <a href="/register" class="text-decoration-none fw-bold">Daftar dulu</a></small>
</div>
        </form>
    </div>
    
    <div class="card-footer bg-white border-0 text-center pb-4">
        <small class="text-muted">© 2025 Sistem Keuangan Kas</small>
    </div>
</div>

</body>
</html>