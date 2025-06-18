<?php
//Memulai session untuk menyimpan error dan form aktif
session_start();

//Menangkap error dari session kalo ada
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

//Menentukan form mana yang aktif(login atau register)
$activeForm = $_SESSION['active_form'] ?? 'login';

//Menghapus data session setelah dibaca
session_unset();

//Fungsi untuk menampilkan pesan error jika ada
function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

//Fungsi untuk menentukan form mana yang ditampilkan
function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- ============================
        Form Login
    ============================= -->
    <div class="container">
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_register.php" method="post">
                <h2>Masuk</h2>
                <?= showError($errors['login']);?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Masuk</button>
                <p>Gapunya akun? <a href="#" onclick="showForm('register-form')">Daftar disini!</a></p>
            </form>
        </div>
    </div>

    <!-- ============================
        Form Register
    ============================= -->

    <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
            <form action="login_register.php" method="post">
                <h2>Daftar Akun</h2>
                <?= showError($errors['register']);?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">-- pilih role -- </option>
                    <option value="">User</option>
                    <option value="">Admin</option>
                </select>
                <button type="submit" name="register">Daftar</button>
                <p>Udah punya akun? <a href="#" onclick="showForm('login-form')">Masuk disini!</a></p>
            </form>
        </div>
    </div>

    <!-- ============================
    javascript untuk menampilkan satu form dan menyembunyikan form-form lainnya 
    ============================ -->
    <script src="script.js"></script>
</body>
</html>