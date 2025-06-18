<?php

// Memulai session untuk menyimpan data session seperti error atau data user
session_start();
require_once 'config.php'; // Memanggil file konfigurasi database

// Proses Register User
if (isset($_POST['register'])) {
    $name = $_POST['name']; // Ambil data nama dari form
    $email = $_POST['email']; // Ambil data email dari form
    // Enkripsi password yang dimasukkan user sebelum disimpan ke database
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $role = $_POST['role']; // Ambil data role dari form (misal admin/user)

    // Cek apakah email sudah terdaftar di database
    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        // Jika email sudah ada, simpan pesan error ke session dan set form yang aktif ke register
        $_SESSION['register_error'] = 'Email sudah terdaftar!';
        $_SESSION['active_form'] = 'register';
    } else {
        // Jika email belum ada, simpan data user baru ke database
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    }
    // Redirect kembali ke halaman index.php (form)
    header("Location: index.php");
    exit();
}

// Proses Login User
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cari data user berdasarkan email di database
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Ambil data user
        // Verifikasi password yang diinputkan dengan password hash di database
        if (password_verify($password, $user['password'])) {
            // Jika password benar, simpan data user ke session
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Cek role user dan arahkan ke halaman sesuai role
            if ($user['role'] === 'admin') {
                header("Location: admin_page.php"); // Jika admin, arahkan ke halaman admin
            } else  {
                header("Location: user_page.php"); // Jika bukan admin, arahkan ke halaman user biasa
            }
            exit(); // Hentikan eksekusi script setelah redirect
        }
    }

    // Jika login gagal, simpan pesan error ke session dan set form aktif ke login
    $_SESSION['login_error'] = 'Email atau kata sandi salah';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php"); // Redirect kembali ke halaman login/register
    exit();
}

?>