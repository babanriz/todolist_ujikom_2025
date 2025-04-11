<?php include "task.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #93a5cf, #e4efe9);
            font-family: 'Segoe UI', sans-serif;
        }
        .register-card {
            animation: slideUp 0.8s ease-in-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card register-card p-4 shadow-lg rounded-4" style="width: 90%; max-width: 350px;">
            <h4 class="text-center mb-4">Daftar Akun Baru</h4>
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button name="register" class="btn btn-success w-100">Daftar</button>
                <p class="text-center mt-3">Sudah punya akun? <a href="index.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
