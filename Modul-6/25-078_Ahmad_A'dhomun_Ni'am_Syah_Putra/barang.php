<?php
include 'koneksi.php';

$pesan = "";

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    $cek = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM transaksi_detail WHERE barang_id = $id");
    $jumlah = mysqli_fetch_assoc($cek)['jumlah'];

    if ($jumlah > 0) {
        $pesan = "Barang tidak bisa dihapus karena masih digunakan pada $jumlah transaksi.";
    } else {
        mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
        $pesan = "Barang berhasil dihapus.";
    }
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h1>Data Barang</h1>
    <p><a href="barang.php">Data Barang</a> | <a href="detail.php">Master-Detail Transaksi</a></p>

    <?php if ($pesan != "") { ?>
        <p><b><?= $pesan ?></b></p>
    <?php } ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($barang)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['kode_barang'] ?></td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['harga'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <form method="post" onsubmit="return confirm('Yakin hapus barang ini?')">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="hapus">Hapus</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>