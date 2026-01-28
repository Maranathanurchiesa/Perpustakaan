<?php
include 'database.php';  


$sql = "SELECT id, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $plain_password = $row['password'];

        
        if (strpos($plain_password, '$2y$') !== 0) {
            
            $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

            
            $update_sql = "UPDATE users SET password = '$hashed_password' WHERE id = $id";
            if ($conn->query($update_sql) === TRUE) {
                echo "Password untuk user dengan ID $id telah di-hash.<br>";
            } else {
                echo "Error updating record: " . $conn->error . "<br>";
            }
        } else {
            echo "Password untuk user dengan ID $id sudah di-hash.<br>";
        }
    }
} else {
    echo "Tidak ada pengguna ditemukan.";
}

$conn->close();
?>
