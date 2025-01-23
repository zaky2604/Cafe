<?php
// Informasi koneksi database
$servername = "localhost"; // Server database (gunakan "127.0.0.1" atau "localhost")
$username = "root"; // Username database (sesuaikan dengan konfigurasi Anda)
$password = ""; // Password database (kosongkan jika menggunakan XAMPP/WAMP bawaan)
$database = "kaskelas"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil!";
}
?>
