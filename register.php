<?php
session_start();
include_once "db_connection.php"; // Pastikan ini berfungsi

// Proses Registrasi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $username = $_POST['reg_username'];
    $password = $_POST['reg_password'];
    $email = $_POST['reg_email'];
    $role = $_POST['reg_role'];

    if (empty($username) || empty($password) || empty($email) || empty($role)) {
        echo "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email tidak valid!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO data_login (username, password, email, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $role);

        if ($stmt->execute()) {
            echo "Registrasi berhasil. Silakan login.";
        } else {
            echo "Gagal registrasi: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registrasi</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="reg_username">Username:</label>
                <input type="text" class="form-control" id="reg_username" name="reg_username" required>
            </div>
            <div class="form-group">
                <label for="reg_password">Password:</label>
                <input type="password" class="form-control" id="reg_password" name="reg_password" required>
            </div>
            <div class="form-group">
                <label for="reg_email">Email:</label>
                <input type="email" class="form-control" id="reg_email" name="reg_email" required>
            </div>
            <button type="submit" name="register" class="btn btn-success btn-block">Registrasi</button>
        </form>
        <p class="text-center mt-3"><a href="index.php">Kembali ke Login</a></p>
    </div>
</body>
</html>