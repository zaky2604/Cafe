<?php
require 'config.php'; // Menghubungkan ke database

// Fungsi untuk menambahkan data customer
if (isset($_POST['add_customer'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO Customer (Nama, Email, No_Telepon, Alamat) VALUES ('$nama', '$email', '$no_telepon', '$alamat')";

    if ($conn->query($query) === TRUE) {
        $customer_id = $conn->insert_id; // Mendapatkan ID customer yang baru ditambahkan
        echo "Customer added successfully! Customer ID: " . $customer_id;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Fungsi untuk memasukkan pesanan
if (isset($_POST['add_pesanan'])) {
    $customer_id = $_POST['customer_id'];
    $tanggal_pemesanan = date('Y-m-d');
    $total_harga = $_POST['total_harga']; // Total harga dihitung berdasarkan jumlah menu yang dipilih
    $status = 'Pending';

    // Insert the Pemesanan data
    $query_pesanan = "INSERT INTO Pemesanan (Tanggal_Pemesanan, Total_Harga, Status, Customer_ID) 
                      VALUES ('$tanggal_pemesanan', '$total_harga', '$status', '$customer_id')";
    
    if ($conn->query($query_pesanan) === TRUE) {
        $pesanan_id = $conn->insert_id; // Mendapatkan Pemesanan_ID

        // Cek apakah menu_id, jumlah, dan subtotal sudah diisi dengan benar
        if (isset($_POST['menu_id']) && !empty($_POST['menu_id']) && isset($_POST['jumlah']) && !empty($_POST['jumlah']) && isset($_POST['subtotal']) && !empty($_POST['subtotal'])) {
            foreach ($_POST['menu_id'] as $index => $menu_id) {
                $jumlah = $_POST['jumlah'][$index];
                $subtotal = $_POST['subtotal'][$index];

                // Pastikan nilai menu_id, jumlah, dan subtotal valid
                if ($menu_id != 0 && $jumlah > 0 && $subtotal > 0) {
                    // Insert data ke dalam Detail_Pemesanan
                    $query_detail = "INSERT INTO Detail_Pemesanan (Pemesanan_ID, Menu_ID, Jumlah, Subtotal) 
                                     VALUES ('$pesanan_id', '$menu_id', '$jumlah', '$subtotal')";
                    if (!$conn->query($query_detail)) {
                        echo "Error: " . $conn->error;
                    }
                }
            }
            echo "Pesanan added successfully!";
        } else {
            echo "Error: Invalid input for menu details. Pastikan semua menu, jumlah, dan subtotal terisi.";
        }

    } else {
        echo "Error: " . $query_pesanan . "<br>" . $conn->error;
    }
}

?>
<!-- HTML Form for Customer & Pesanan -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Customer & Pesanan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Input Customer dan Pesanan</h1>
        <nav>
            <a href="index.php" class="btn">Home</a>
            <a href="menu.php" class="btn">Menu</a>
            <a href="pesanan.php" class="btn">Pesanan</a>
            <a href="pembayaran.php" class="btn">Pembayaran</a>
            <a href="pembayaran_terbayar.php" class="btn">Berhasil</a>
        </nav>
    </header>
    <main>
        <!-- Form Input Customer -->
        <section>
            <h2>Data Customer</h2>
            <form method="POST" action="pesanan.php">
                <label for="nama">Nama Customer:</label>
                <input type="text" id="nama" name="nama" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="no_telepon">No. Telepon:</label>
                <input type="text" id="no_telepon" name="no_telepon" required><br>

                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" required></textarea><br>

                <button type="submit" name="add_customer">Tambah Customer</button>
            </form>
        </section>

        <!-- Form Input Pesanan -->
        <section>
            <h2>Input Pesanan</h2>
            <form method="POST" action="pesanan.php">
                <label for="customer_id">Pilih Customer:</label>
                <select id="customer_id" name="customer_id" required>
                    <?php
                    // Menampilkan daftar customer untuk memilih customer yang sudah terdaftar
                    $sql = "SELECT * FROM Customer";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['Customer_ID']}'>{$row['Nama']}</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada data customer</option>";
                    }
                    ?>
                </select><br>

                <label for="menu">Pilih Menu:</label>
                <table>
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query untuk mengambil data menu
                        $sql = "SELECT * FROM Menu";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td><input type='checkbox' name='menu_id[]' value='{$row['Menu_ID']}' data-harga='{$row['Harga']}' class='menu_check'></td>
                                    <td>{$row['Nama_Menu']}</td>
                                    <td>Rp " . number_format($row['Harga'], 2, ',', '.') . "</td>
                                    <td>{$row['Kategori']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tidak ada menu</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div id="order_details"></div>

                <input type="hidden" name="total_harga" value="0">

                <button type="submit" name="add_pesanan">Tambah Pesanan</button>
            </form>
        </section>
    </main>

    <script>
        // Script untuk menambahkan detail pesanan (jumlah dan subtotal)
        document.querySelectorAll('.menu_check').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                let orderDetails = document.getElementById('order_details');
                let totalHarga = 0;
                orderDetails.innerHTML = '';

                // Generate fields for selected items
                document.querySelectorAll('.menu_check:checked').forEach(function (checkedBox) {
                    let row = checkedBox.closest('tr');
                    let harga = parseFloat(checkedBox.dataset.harga);
                    let menuId = checkedBox.value;
                    let jumlahInput = `<input type="number" name="jumlah[]" value="1" min="1" class="jumlah" data-harga="${harga}" required>`;
                    let subtotalInput = `<input type="text" name="subtotal[]" value="${harga}" readonly class="subtotal">`;

                    orderDetails.innerHTML += `<div>
                        <label>Menu: ${row.cells[1].textContent}</label><br>
                        ${jumlahInput} x <span class="harga">Rp ${harga.toFixed(2).replace('.', ',')}</span><br>
                        Subtotal: ${subtotalInput}<br>
                    </div>`;

                    totalHarga += harga; // Update total harga
                });

                // Update total harga in the hidden input field
                document.querySelector('input[name="total_harga"]').value = totalHarga.toFixed(2); // Set total_harga field

                // Update subtotal when quantity changes
                document.querySelectorAll('.jumlah').forEach(function (input) {
                    input.addEventListener('input', function () {
                        let harga = parseFloat(input.dataset.harga);
                        let jumlah = input.value;
                        let subtotal = harga * jumlah;
                        input.closest('div').querySelector('.subtotal').value = subtotal.toFixed(2);

                        // Recalculate total harga after quantity change
                        totalHarga = 0;
                        document.querySelectorAll('.subtotal').forEach(function (subtotalInput) {
                            totalHarga += parseFloat(subtotalInput.value);
                        });
                        
                        // Update total harga input field again after recalculating
                        document.querySelector('input[name="total_harga"]').value = totalHarga.toFixed(2);
                    });
                });
            });
        });

    </script>
</body>
</html>
