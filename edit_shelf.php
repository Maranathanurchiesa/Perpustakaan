<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $shelf_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM shelves WHERE id = ?");
    $stmt->bind_param("i", $shelf_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $shelf = $result->fetch_assoc();
    } else {
        echo "Rak tidak ditemukan.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_shelf'])) {
    $shelf_id = $_POST['shelf_id'];
    $name = $_POST['shelf_name'];
    $location = $_POST['shelf_location'];

    $stmt = $conn->prepare("UPDATE shelves SET name = ?, location = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $location, $shelf_id);

    if ($stmt->execute()) {
        header("Location: rak_buku.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Rak Buku</title>

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
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(0,0,0,.2);
    width: 100%;
    max-width: 520px;
}

h1 {
    text-align: center;
    margin-bottom: 25px;
}

/* FORM */
label {
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
}

input[type="text"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 15px;
}

input:focus {
    outline: none;
    border-color: #0d6efd;
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: none;
    background: #0d6efd;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: .3s;
}

button:hover {
    background: #084298;
}
</style>
</head>

<body>

<div class="card">
    <h1>✏️ Edit Rak Buku</h1>

    <form method="POST">
        <input type="hidden" name="shelf_id" value="<?= $shelf['id'] ?>">

        <label>Nama Rak</label>
        <input type="text" name="shelf_name"
               value="<?= htmlspecialchars($shelf['name']) ?>" required>

        <label>Lokasi Rak</label>
        <input type="text" name="shelf_location"
               value="<?= htmlspecialchars($shelf['location']) ?>" required>

        <button type="submit" name="edit_shelf">
            💾 Simpan Perubahan
        </button>
    </form>
</div>

</body>
</html>
