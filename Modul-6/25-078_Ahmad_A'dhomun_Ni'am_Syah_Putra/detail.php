<?php
include 'koneksi.php';

$pesan = "";
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (isset($_POST['simpan'])) {
    $id        = (int) $_POST['transaksi_id'];
    $barang_id = (int) $_POST['barang_id'];
    $qty       = (int) $_POST['qty'];

    $barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = $barang_id"));
    $cek    = mysqli_query($koneksi, "SELECT * FROM transaksi_detail WHERE transaksi_id = $id AND barang_id = $barang_id");

    if (!$barang || $qty < 1) {
        $pesan = "Pilih barang dan isi qty minimal 1.";
    } elseif (mysqli_num_rows($cek) > 0) {
        $pesan = "Barang sudah ada di transaksi ini.";
    } else {
        $harga = $barang['harga'];

        mysqli_query($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ($id, $barang_id, $harga, $qty)");

        mysqli_query($koneksi, "UPDATE transaksi SET total = (SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id = $id) WHERE id = $id");

        $pesan = "Detail berhasil disimpan, total transaksi diperbarui.";
    }
}

$daftar = mysqli_query($koneksi, "SELECT transaksi.id, waktu_transaksi, nama FROM transaksi JOIN pelanggan ON pelanggan.id = transaksi.pelanggan_id");

$master = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT transaksi.*, pelanggan.nama FROM transaksi JOIN pelanggan ON pelanggan.id = transaksi.pelanggan_id WHERE transaksi.id = $id"));

$detail = mysqli_query($koneksi, "SELECT nama_barang, transaksi_detail.harga, qty FROM transaksi_detail JOIN barang ON barang.id = transaksi_detail.barang_id WHERE transaksi_id = $id");

$semua = mysqli_query($koneksi, "SELECT id, nama_barang, harga, (SELECT COUNT(*) FROM transaksi_detail WHERE transaksi_id = $id AND barang_id = barang.id) AS terpakai FROM barang");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Master-Detail Transaksi</title>
</head>
<body>
    <h1>Master-Detail Transaksi</h1>
    <p><a href="barang.php">Data Barang</a> | <a href="detail.php">Master-Detail Transaksi</a></p>

    <?php if ($pesan != "") { ?>
        <p><b><?= $pesan ?></b></p>
    <?php } ?>

    <form method="get">
        Pilih Transaksi:
        <select name="id">
            <?php while ($t = mysqli_fetch_assoc($daftar)) { ?>
                <option value="<?= $t['id'] ?>" <?= $t['id'] == $id ? 'selected' : '' ?>>
                    #<?= $t['id'] ?> - <?= $t['waktu_transaksi'] ?> - <?= $t['nama'] ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Load</button>
    </form>

    <?php if ($master) { ?>

    <h2>Master</h2>
    <table border="1">
        <tr><td>ID</td><td><?= $master['id'] ?></td></tr>
        <tr><td>Tanggal</td><td><?= $master['waktu_transaksi'] ?></td></tr>
        <tr><td>Pelanggan</td><td><?= $master['nama'] ?></td></tr>
        <tr><td>Keterangan</td><td><?= $master['keterangan'] ?></td></tr>
        <tr><td>Total</td><td><?= $master['total'] ?></td></tr>
    </table>

    <h2>Detail</h2>
    <table border="1">
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
        <tr>
            <td><?= $d['nama_barang'] ?></td>
            <td><?= $d['harga'] ?></td>
            <td><?= $d['qty'] ?></td>
            <td><?= $d['harga'] * $d['qty'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Tambah Barang</h2>
    <form method="post">
        <input type="hidden" name="transaksi_id" value="<?= $id ?>">
        Barang:
        <select name="barang_id">
            <option value="0">-- Pilih Barang --</option>
            <?php while ($b = mysqli_fetch_assoc($semua)) { ?>
                <option value="<?= $b['id'] ?>" <?= $b['terpakai'] > 0 ? 'disabled' : '' ?>>
                    <?= $b['nama_barang'] ?> (<?= $b['harga'] ?>)
                </option>
            <?php } ?>
        </select>
        Qty: <input type="number" name="qty" value="1" min="1">
        <button type="submit" name="simpan">Simpan</button>
    </form>

    <?php } ?>
</body>
</html>