<?php
require 'config.php'; // Connect to database

// Handle menu deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM Menu WHERE Menu_ID = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Menu deleted successfully!";
        header("Location: menu.php"); // Redirect after deletion
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle menu editing
if (isset($_POST['update_menu'])) {
    $menu_id = $_POST['menu_id'];
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    // Update query
    $query = "UPDATE Menu SET Nama_Menu='$nama_menu', Harga='$harga', Deskripsi='$deskripsi', Kategori='$kategori' WHERE Menu_ID='$menu_id'";

    if ($conn->query($query) === TRUE) {
        echo "Menu updated successfully!";
        header("Location: menu.php"); // Redirect after update
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch menu data for editing (if edit_id is set)
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM Menu WHERE Menu_ID = $edit_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $menu_data = $result->fetch_assoc();
    } else {
        echo "Menu item not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Menu Management</h1>
        <nav>
            <a href="index.php" class="btn">Home</a>
            <a href="menu.php" class="btn">Menu</a>
            <a href="pesanan.php" class="btn">Pesanan</a>
            <a href="pembayaran.php" class="btn">Pembayaran</a>
            <a href="pembayaran_terbayar.php" class="btn">Berhasil</a>
        </nav>
    </header>
    <main>
        <!-- Add Menu Section -->
        <section>
            <h2>Add Menu</h2>
            <form method="POST" action="">
                <label for="nama_menu">Nama Menu:</label>
                <input type="text" id="nama_menu" name="nama_menu" required><br>

                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" required><br>

                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" required></textarea><br>

                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" required>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                </select><br>

                <button type="submit" name="add_menu">Add Menu</button>
            </form>
        </section>

        <!-- Edit Menu Section (Only if editing) -->
        <?php if (isset($menu_data)): ?>
        <section>
            <h2>Edit Menu</h2>
            <form method="POST" action="">
                <input type="hidden" name="menu_id" value="<?php echo $menu_data['Menu_ID']; ?>">

                <label for="nama_menu">Nama Menu:</label>
                <input type="text" id="nama_menu" name="nama_menu" value="<?php echo $menu_data['Nama_Menu']; ?>" required><br>

                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" value="<?php echo $menu_data['Harga']; ?>" required><br>

                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" required><?php echo $menu_data['Deskripsi']; ?></textarea><br>

                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" required>
                    <option value="Makanan" <?php echo ($menu_data['Kategori'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                    <option value="Minuman" <?php echo ($menu_data['Kategori'] == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                </select><br>

                <button type="submit" name="update_menu">Update Menu</button>
            </form>
        </section>
        <?php endif; ?>

        <!-- Menu List Section -->
        <section>
            <h2>Data Menu</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display menu items
                    $sql = "SELECT * FROM Menu";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['Menu_ID']}</td>
                                <td>{$row['Nama_Menu']}</td>
                                <td>Rp " . number_format($row['Harga'], 2, ',', '.') . "</td>
                                <td>{$row['Kategori']}</td>
                                <td>{$row['Deskripsi']}</td>
                                <td>
                                    <a href=\"?edit_id={$row['Menu_ID']}\" class=\"btn\">Edit</a>
                                    <a href=\"?delete_id={$row['Menu_ID']}\" class=\"btn\" onclick=\"return confirm('Are you sure you want to delete this menu item?')\">Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
