<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Yonkonif</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar .profile-img {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border: 2px solid #fff;
        }
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3 mb-4">
    <div class="container">

        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
            <i class="bi bi-hospital me-2"></i> Klinik Sehat
        </a>

        <!-- Toggle Button Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('dokter.index') }}">
                        <i class="bi bi-person-badge me-1"></i> Data Dokter
                    </a>
                </li>

                  <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('ruangan.index') }}">
                        <i class="bi bi-person-badge me-2"></i> Data Ruangan
                    </a>
                    <li class="nav-item">
                         <a class="nav-link px-3" href="{{ route('pasien.index') }}">
                        <i class="bi bi-person-badge me-2"></i> Data Pasien
                    </a>
                    
                    </li>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->foto)
                            <img src="{{ asset('profil/' . Auth::user()->foto) }}" alt="Foto Profil" class="rounded-circle profile-img me-2">
                        @else
                            <i class="bi bi-person-circle me-2 fs-4"></i>
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end p-3" style="min-width: 250px;">
                        <li class="mb-2 text-center">
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <small class="text-muted">Level: {{ Auth::user()->role }}</small>
                        </li>

                        <!-- Form Upload Foto -->
                        <li class="mb-2">
                            <form action="{{ route('upload.foto') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="foto" class="form-control form-control-sm mb-2" accept="image/*" required>
                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                    <i class="bi bi-upload me-1"></i> Upload Foto
                                </button>
                            </form>
                        </li>

                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger d-flex align-items-center" href="{{ route('actionlogout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i> Log Out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
