<?php
session_start();
require_once 'database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi.";
    } else {

        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                // SIMPAN SESSION
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name']    = $user['name'];
                $_SESSION['role']    = $user['role'];

                // REDIRECT SESUAI ROLE (INI YANG DIPERBAIKI)
                if ($user['role'] === 'admin') {
                    header("Location: menuadmin.php");
                } else {
                    header("Location: usermenu.php");
                }
                exit();

            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Email tidak terdaftar.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background-image: url('img/bg1.png');
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
    </style>
</head>
<body>

<div class="card shadow-lg p-4">
    <div class="text-center mb-3">
        <i class="bi bi-book-half fs-1 text-primary"></i>
        <h4 class="mt-2">Login Perpustakaan</h4>
        <small class="text-muted">Admin & Pengguna</small>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
        <div class="alert alert-success text-center">
            Registrasi berhasil, silakan login.
        </div>
    <?php endif; ?>

    <form method="POST">
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
                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
        </div>

        <button class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </button>

        <div class="text-center mt-3">
            <small>Belum punya akun?
                <a href="register.php">Daftar</a>
            </small>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const p = document.getElementById("password");
    p.type = p.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
