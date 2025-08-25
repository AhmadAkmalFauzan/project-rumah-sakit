<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi OTP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4f8ef7, #6fd5f7);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .otp-input {
            letter-spacing: 5px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <h3 class="text-center mb-4">📧 Verifikasi OTP</h3>
                    <p class="text-center text-muted">Kode OTP telah dikirim ke <strong>{{ $email }}</strong></p>
                    <form method="POST" action="{{ route('otp.form.verify.submit') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-3">
                            <label class="form-label">Kode OTP</label>
                            <input type="text" name="otp" class="form-control otp-input" maxlength="6" placeholder="••••••" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('otp.send') }}" class="text-decoration-none">Kirim ulang OTP</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
