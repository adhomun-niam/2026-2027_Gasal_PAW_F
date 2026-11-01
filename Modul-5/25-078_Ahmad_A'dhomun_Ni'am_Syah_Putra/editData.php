<?php
include 'koneksi.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM supplier WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = $pdo->prepare("UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
    $stmt->execute([$nama, $telp, $alamat, $id]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Master Supplier</title>
</head>
<body>

    <h2>Edit Data Master Supplier</h2>

    <form method="POST">
        <table>
            <tr>
                <td>Nama</td>
                <td>: <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required></td>
            </tr>
            <tr>
                <td>Telp</td>
                <td>: <input type="text" name="telp" value="<?= htmlspecialchars($data['telp']); ?>" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat']); ?>" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Simpan Perubahan</button>
                    <a href="index.php"><button type="button">Batal</button></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>