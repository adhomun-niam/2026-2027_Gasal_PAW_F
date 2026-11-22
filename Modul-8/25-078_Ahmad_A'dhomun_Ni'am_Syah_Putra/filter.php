<?php
include "koneksi.php";
include "cek_login.php";

$tanggal_mulai = $_GET['tanggal_mulai'] ?? "";
$tanggal_akhir = $_GET['tanggal_akhir'] ?? "";

if ($tanggal_mulai != "" && $tanggal_akhir != "") {
    $mulai = mysqli_real_escape_string($koneksi, $tanggal_mulai);
    $akhir = mysqli_real_escape_string($koneksi, $tanggal_akhir);

    $query = "SELECT DATE(waktu_transaksi) AS tanggal, SUM(total) AS total_harian FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$akhir' GROUP BY DATE(waktu_transaksi) ORDER BY tanggal ASC";
    $query_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$akhir'";

} else {
    $query = "SELECT DATE(waktu_transaksi) AS tanggal, SUM(total) AS total_harian FROM transaksi GROUP BY DATE(waktu_transaksi) ORDER BY tanggal ASC";

    $query_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah FROM transaksi";
}

$hasil = mysqli_query($koneksi, $query);

$labels = [];
$data = [];
$rekap = [];
$total_pendapatan = 0;

while ($row = mysqli_fetch_assoc($hasil)) {
    $labels[] = $row['tanggal'];
    $data[] = (int) $row['total_harian'];
    $rekap[] = $row;
    $total_pendapatan += $row['total_harian'];
}

$hasil_pelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, $query_pelanggan));
$jumlah_pelanggan = $hasil_pelanggan['jumlah'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="isi">
<h2>Rekap Laporan Penjualan</h2>
<div class="no-print">
    <form method="GET">
        Tanggal Mulai: <input type="date" name="tanggal_mulai" value="<?php echo htmlspecialchars($tanggal_mulai); ?>" required>
        Tanggal Akhir: <input type="date" name="tanggal_akhir" value="<?php echo htmlspecialchars($tanggal_akhir); ?>" required>
        <button type="submit">Tampilkan</button>
    </form>
    <br>
    <button onclick="window.print()">Cetak</button>
    <a href="excel.php?tanggal_mulai=<?php echo urlencode($tanggal_mulai); ?>&tanggal_akhir=<?php echo urlencode($tanggal_akhir); ?>"><button>Excel</button></a>
</div>

<?php if ($tanggal_mulai != "" && $tanggal_akhir != "") { ?>
    <p>Periode: <?php echo htmlspecialchars($tanggal_mulai); ?> sampai <?php echo htmlspecialchars($tanggal_akhir); ?></p>
<?php } else { ?>
    <p>Periode: semua data</p>
<?php } ?>

<?php if (count($rekap) == 0) { ?>
    <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>
<?php } else { ?>

    <h3>Grafik Penjualan</h3>
    <canvas id="grafik" width="600" height="300"></canvas>
    <script>
        new Chart(document.getElementById('grafik'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    data: <?php echo json_encode($data); ?>
                }]
            },
            options: { responsive: false }
        });
    </script>

    <h3>Rekapitulasi</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Total Pendapatan</th>
            <th>Tanggal Transaksi</th>
        </tr>
        <?php $no = 1; foreach ($rekap as $row) { ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td>Rp. <?php echo number_format($row['total_harian'], 0, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Jumlah Pelanggan</th>
            <th>Jumlah Pendapatan</th>
        </tr>
        <tr>
            <td><?php echo $jumlah_pelanggan; ?> Orang</td>
            <td>Rp. <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></td>
        </tr>
    </table>

<?php } ?>
</div>
</body>
</html>