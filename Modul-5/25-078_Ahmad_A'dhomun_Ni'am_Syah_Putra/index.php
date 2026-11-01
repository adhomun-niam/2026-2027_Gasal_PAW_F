<?php
include 'koneksi.php';

$stmt = $pdo->query("SELECT * FROM supplier");
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master Supplier</title>
    <script>
        function konfirmasiHapus(id) {
            let konfirmasi = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (konfirmasi) {
                window.location.href = "hapusData.php?id=" + id;
            }
        }
    </script>
</head>
<body>

    <h2>Data Master Supplier</h2>
    
    <p><a href="tambahData.php"><button>Tambah Data Supplier Baru</button></a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($suppliers as $row): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['telp']); ?></td>
                <td><?= htmlspecialchars($row['alamat']); ?></td>
                <td>
                    <a href="editData.php?id=<?= $row['id']; ?>"><button>Edit</button></a>
                    <button onclick="konfirmasiHapus(<?= $row['id']; ?>)">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>