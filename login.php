<?php
session_start();
include_once "db_connection.php"; // Pastikan ini berfungsi

// Proses Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa kecocokan data login
    $query = "SELECT * FROM data_login WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika login berhasil, simpan data user ke session
            $_SESSION['username'] = $user['username'];

            header("Location: data/view_data_warga.php"); // Redirect ke halaman home
            exit();
        } else {
            $_SESSION['error'] = "Username atau password salah";
        }
    } else {
        $_SESSION['error'] = "Username atau password salah";
    }
}

// Cek jika pengguna sudah login
$isLoggedIn = isset($_SESSION['username']);

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php"); // Redirect ke halaman login setelah logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css"> <!-- CSS tambahan jika ada -->
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Sistem Desa</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php if (!$isLoggedIn): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?logout=true">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-7 col-lg-5 col-xl-5">
                    <?php if (!$isLoggedIn): ?>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger mt-3"><?php echo $_SESSION['error'];
                                                                    unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <h3 class="text-center">Login Sistem Desa</h3>
                        <form method="POST" action="login.php">
                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="form1Example13">Username</label>
                                <input type="text" id="form1Example13" class="form-control form-control-lg" name="username" />
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="form1Example23">Password</label>
                                <input type="password" id="form1Example23" class="form-control form-control-lg" name="password" />
                            </div>
                            <!-- Submit button -->
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" name="login">Login</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- <div class="container mt-5">
        <?php if (!$isLoggedIn): ?>
            <h1>Login</h1>
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" name="login" class="btn btn-primary">Login</button ```php
            </form>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger mt-3"><?php echo $_SESSION['error'];
                                                        unset($_SESSION['error']); ?></div>
            <?php endif; ?>
        <?php else: ?>
            <h1>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
            <p>Anda telah berhasil login.</p>
        <?php endif; ?>
    </div> -->
</body>

</html>