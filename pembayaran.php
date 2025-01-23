<?php
require 'config.php'; // Menghubungkan ke database

// Fungsi untuk menambahkan data pembayaran
if (isset($_POST['add_pembayaran'])) {
    $pemesanan_id = $_POST['pemesanan_id'];
    $tanggal_pembayaran = date('Y-m-d');
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $jumlah_pembayaran = $_POST['jumlah_pembayaran'];

    // Query untuk memasukkan data pembayaran
    $query = "INSERT INTO Pembayaran (Pemesanan_ID, Tanggal_Pembayaran, Metode_Pembayaran, Jumlah_Pembayaran) 
              VALUES ('$pemesanan_id', '$tanggal_pembayaran', '$metode_pembayaran', '$jumlah_pembayaran')";

    if ($conn->query($query) === TRUE) {
        echo "Pembayaran berhasil ditambahkan!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pembayaran</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Function to update the payment amount field based on selected order
        function updatePaymentAmount() {
            var pemesananId = document.getElementById('pemesanan_id').value;
            var totalHarga = document.getElementById('pemesanan_id').options[document.getElementById('pemesanan_id').selectedIndex].getAttribute('data-total');
            if (pemesananId !== '') {
                document.getElementById('jumlah_pembayaran').value = totalHarga;
            } else {
                document.getElementById('jumlah_pembayaran').value = '';
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Manajemen Pembayaran</h1>
        <nav>
            <a href="index.php" class="btn">Home</a>
            <a href="menu.php" class="btn">Menu</a>
            <a href="pesanan.php" class="btn">Pesanan</a>
            <a href="pembayaran.php" class="btn">Pembayaran</a>
            <a href="pembayaran_terbayar.php" class="btn">Berhasil</a>
        </nav>
    </header>
    <main>
        <!-- Form Tambah Pembayaran -->
        <section>
            <h2>Tambah Pembayaran</h2>
            <form method="POST" action="">
                <label for="pemesanan_id">Pilih Pemesanan:</label>
                <select id="pemesanan_id" name="pemesanan_id" required onchange="updatePaymentAmount()">
                    <?php
                    // Mengambil daftar pemesanan yang belum dibayar
                    $sql = "SELECT * FROM Pemesanan 
                            WHERE Pemesanan_ID NOT IN (SELECT Pemesanan_ID FROM Pembayaran)";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['Pemesanan_ID']}' data-total='{$row['Total_Harga']}'>Pesanan ID: {$row['Pemesanan_ID']} (Total: Rp " . number_format($row['Total_Harga'], 2, ',', '.') . ")</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada data pesanan</option>";
                    }
                    ?>
                </select><br>

                <label for="metode_pembayaran">Metode Pembayaran:</label>
                <select id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="Cash">Cash</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select><br>

                <label for="jumlah_pembayaran">Jumlah Pembayaran:</label>
                <input type="number" id="jumlah_pembayaran" name="jumlah_pembayaran" step="0.01" required><br>

                <button type="submit" name="add_pembayaran">Tambah Pembayaran</button>
            </form>
        </section>

        <!-- Tabel Data Pembayaran -->
        <section>
            <h2>Data Pembayaran</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pembayaran</th>
                        <th>ID Pemesanan</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menampilkan daftar pembayaran dari database
                    $sql = "SELECT * FROM Pembayaran";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['Pembayaran_ID']}</td>
                                <td>{$row['Pemesanan_ID']}</td>
                                <td>{$row['Tanggal_Pembayaran']}</td>
                                <td>{$row['Metode_Pembayaran']}</td>
                                <td>Rp " . number_format($row['Jumlah_Pembayaran'], 2, ',', '.') . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data pembayaran</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
