<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
<div class="card p-4 shadow-sm" style="min-width: 300px;">
    <h3 class="mb-3">Login</h3>
    @if(session('lockout') || session('error'))
    <div id="alertBox" class="alert {{ session('lockout') ? 'alert-warning' : 'alert-danger' }}">
        @if(session('lockout'))
            <strong>Notifikasi:</strong> Anda telah memasukkan password sebanyak 5x.<br>
            Silakan coba lagi dalam <span id="countdown">{{ session('remaining') }}</span> detik.
        @else
            <b>Oops!</b> {{ session('error') }}
        @endif
    </div>

    @if(session('lockout'))
    <script>
        let countdown = {{ session('remaining') }};
        const countdownEl = document.getElementById('countdown');
        const alertBox = document.getElementById('alertBox');

        const timer = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                clearInterval(timer);
                if (alertBox) alertBox.remove();

                // Optional: reload page to clear session or unlock form
                // location.reload(); // uncomment if needed
            } else {
                countdownEl.innerText = countdown;
            }
        }, 1000);
    </script>
    @endif
    @endif
    <form method="POST" action="{{ route('actionlogin') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <p class="mt-3 text-center">
            Belum punya akun? <a href="{{ route('register') }}">Register</a>
        </p>
        <p class="mt-3 text-center">
            Lupa Password? <a href="{{ route('password.reset.otp.form') }}">Reset Password</a>
        </p>
        <button class="btn btn-primary w-100">Login</button>
    </form>
</div>
</body>
</html>
