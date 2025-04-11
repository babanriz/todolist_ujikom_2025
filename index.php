<?php include "task.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #93a5cf, #e4efe9);
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        #loading-screen {
            position: fixed;
            z-index: 9999;
            background: #fff;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div id="loading-screen">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card login-card p-4 shadow-lg rounded-4" style="width: 90%; max-width: 350px;">
            <h4 class="text-center mb-4">Login To-Do List</h4>
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button name="login" class="btn btn-primary w-100">Login</button>
                <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
            </form>
        </div>
    </div>

    <script>
        window.onload = () => {
            setTimeout(() => {
                document.getElementById('loading-screen').style.display = 'none';
            }, 1500); // waktu loading 1.5 detik
        };
    </script>
</body>
</html>
