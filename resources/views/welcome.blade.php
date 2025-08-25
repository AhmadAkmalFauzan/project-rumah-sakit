<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Sehat - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Hero Section */
        .hero {
            background: url('https://images.unsplash.com/photo-1584515933487-779824d29309') center/cover no-repeat;
            color: white;
            position: relative;
        }
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero .container {
            position: relative;
            z-index: 2;
        }
        /* Card Hover Effect */
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
            <i class="bi bi-hospital me-2"></i> Klinik Sehat
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ auth()->check() ? route('ruangan.index') : route('login') }}">
                        <i class="bi bi-person-badge me-1"></i> Ruangan
                    </a>
                </li>
            </ul>

              <ul class="navbar-nav me-left">
                <li class="nav-item">
                    <a class="nav-link" href="{{ auth()->check() ? route('dokter.index') : route('login') }}">
                        <i class="bi bi-person-badge me-1"></i> Dokter
                    </a>
                </li>
            </ul>

            <div class="d-flex">
                @auth
                    <a class="dropdown-item text-white" href="{{ route('actionlogout') }}">
                        <i class="bi bi-box-arrow-right me-1"></i> Log Out
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero py-5 text-center">
    <div class="container py-5">
        <h1 class="display-4 fw-bold">Selamat Datang di Klinik Sehat</h1>
        <p class="lead mb-4">Layanan kesehatan profesional untuk semua kebutuhan medis Anda.</p>
        <a href="{{ route('ruangan.index') }}" class="btn btn-warning btn-lg fw-semibold">
            <i class="bi bi-search-heart me-1"></i> Lihat Daftar Dokter
        </a>
    </div>
</section>

<!-- Layanan Section -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-4 fw-bold">Layanan Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card service-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bi bi-heart-pulse display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Poli Umum</h5>
                        <p class="card-text">Layanan pemeriksaan dan pengobatan untuk berbagai keluhan kesehatan umum.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bi bi-tooth display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Poli Gigi</h5>
                        <p class="card-text">Perawatan gigi dan mulut oleh dokter gigi berpengalaman.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bi bi-eye display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Poli Mata</h5>
                        <p class="card-text">Pemeriksaan mata dan penanganan masalah penglihatan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h2 class="mb-4 fw-bold">Testimoni Pasien</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"Pelayanan cepat dan ramah. Dokternya profesional!"</p>
                    <footer class="blockquote-footer">Andi, <cite title="Source Title">Jakarta</cite></footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"Tempatnya bersih, stafnya membantu, saya sangat puas."</p>
                    <footer class="blockquote-footer">Sinta, <cite title="Source Title">Bekasi</cite></footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"Klinik terbaik, fasilitas lengkap dan modern."</p>
                    <footer class="blockquote-footer">Budi, <cite title="Source Title">Depok</cite></footer>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-4">
    <div class="container">
        <p class="mb-2">&copy; {{ date('Y') }} Klinik Sehat. All rights reserved.</p>
        <div>
            <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-white"><i class="bi bi-twitter"></i></a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
