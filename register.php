<?php
session_start();
require_once 'database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']); // ✅ FIX TYPO
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Semua field wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {

        // cek email sudah terdaftar
        $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $cek->bind_param("s", $email);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $error = "Email sudah terdaftar.";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = "user";

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $name, $email, $hash, $role);

            if ($stmt->execute()) {
                header("Location: loginawal.php?register=success");
                exit();
            } else {
                $error = "Registrasi gagal.";
            }

            $stmt->close();
        }
        $cek->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background-image: url('img/bg1.png'); /* BACKGROUND TETAP */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            max-width: 420px;
            width: 100%;
            border-radius: 18px;
        }
        .input-group-text {
            background: #f1f3f5;
        }
    </style>
</head>
<body>

<div class="card shadow-lg p-4">
    <div class="text-center mb-3">
        <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
        <h4 class="mt-2">Registrasi Akun</h4>
        <small class="text-muted">Sistem Perpustakaan</small>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" id="password" name="password" class="form-control" required>
                <span class="input-group-text" style="cursor:pointer" onclick="togglePassword()">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
            </div>
            <small class="text-muted">Minimal 6 karakter</small>
        </div>

        <button class="btn btn-primary w-100">
            <i class="bi bi-check-circle"></i> Daftar
        </button>

        <div class="text-center mt-3">
            <small>Sudah punya akun?
                <a href="loginawal.php">Login</a>
            </small>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

</body>
</html>
