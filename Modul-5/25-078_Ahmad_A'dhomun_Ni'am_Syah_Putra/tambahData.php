<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = $pdo->prepare("INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
    $stmt->execute([$nama, $telp, $alamat]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Master Supplier Baru</title>
</head>
<body>

    <h2>Tambah Data Master Supplier Baru</h2>

    <form method="POST">
        <table>
            <tr>
                <td>Nama</td>
                <td>: <input type="text" name="nama" required></td>
            </tr>
            <tr>
                <td>Telp</td>
                <td>: <input type="text" name="telp" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <input type="text" name="alamat" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Simpan</button>
                    <a href="index.php"><button type="button">Batal</button></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>