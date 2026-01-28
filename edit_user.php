<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Pengguna tidak ditemukan.";
        exit();
    }
} else {
    echo "ID pengguna tidak ada.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    $sql = "UPDATE users 
            SET name='$name', email='$email', role='$role' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Pengguna</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: url('img/bg1.png') center/cover no-repeat;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD */
.card {
    background: rgba(255,255,255,.95);
    max-width: 520px;
    width: 100%;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(0,0,0,.2);
}

/* TITLE */
h1 {
    text-align: center;
    color: #0d6efd;
    margin-bottom: 25px;
}

/* FORM */
label {
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
}

input, select {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 15px;
}

input:focus, select:focus {
    outline: none;
    border-color: #0d6efd;
}

/* BUTTON */
.btn-save {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: none;
    background: #28a745;
    color: #fff;
    font-weight: 500;
    cursor: pointer;
    transition: .3s;
}

.btn-save:hover {
    background: #218838;
}
</style>
</head>

<body>

<div class="card">
    <h1>✏️ Edit Pengguna</h1>

    <form method="POST">
        <label>Nama</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Role</label>
        <select name="role">
            <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
            <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
        </select>

        <button class="btn-save" type="submit">
            💾 Simpan Perubahan
        </button>
    </form>
</div>

</body>
</html>
