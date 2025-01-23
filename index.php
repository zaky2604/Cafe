<?php
require 'config.php'; // Menghubungkan ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Dashboard</h1>
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
            <h2>Data Customer</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data customer
                    $sql = "SELECT * FROM Customer";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['Customer_ID']}</td>
                                <td>{$row['Nama']}</td>
                                <td>{$row['Email']}</td>
                                <td>{$row['No_Telepon']}</td>
                                <td>{$row['Alamat']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
