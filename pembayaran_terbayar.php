<?php
require 'config.php'; // Menghubungkan ke database

// Query untuk menampilkan daftar pesanan yang sudah dibayar
$sql = "
    SELECT p.Pemesanan_ID, p.Tanggal_Pemesanan, p.Total_Harga, pb.Tanggal_Pembayaran, pb.Metode_Pembayaran, pb.Jumlah_Pembayaran
    FROM Pemesanan p
    JOIN Pembayaran pb ON p.Pemesanan_ID = pb.Pemesanan_ID
    WHERE pb.Jumlah_Pembayaran >= p.Total_Harga
    GROUP BY p.Pemesanan_ID
    ORDER BY p.Tanggal_Pemesanan DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan yang Sudah Dibayar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Daftar Pesanan yang Sudah Dibayar</h1>
        <nav>
            <a href="index.php" class="btn">Home</a>
            <a href="menu.php" class="btn">Menu</a>
            <a href="pesanan.php" class="btn">Pesanan</a>
            <a href="pembayaran.php" class="btn">Pembayaran</a>
            <a href="pembayaran_terbayar.php" class="btn">Berhasil</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Daftar Pesanan yang Sudah Dibayar</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pemesanan</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Total Harga</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menampilkan hasil query
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['Pemesanan_ID']}</td>
                                    <td>{$row['Tanggal_Pemesanan']}</td>
                                    <td>Rp " . number_format($row['Total_Harga'], 2, ',', '.') . "</td>
                                    <td>{$row['Tanggal_Pembayaran']}</td>
                                    <td>{$row['Metode_Pembayaran']}</td>
                                    <td>Rp " . number_format($row['Jumlah_Pembayaran'], 2, ',', '.') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada pesanan yang sudah dibayar</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
