<?php
$level = $_SESSION['level'];
?>
<div class="no-print">
    <a href="index.php">Home</a> |

    <?php if ($level == 1) { ?>
    Data Master:
    <a href="barang.php">Data Barang</a>,
    <a href="supplier.php">Data Supplier</a>,
    <a href="pelanggan.php">Data Pelanggan</a>,
    <a href="user.php">Data User</a> |
    <?php } ?>

    <a href="detail.php">Transaksi</a> |
    <a href="filter.php">Laporan</a> |

    Login sebagai: <?php echo htmlspecialchars($_SESSION['nama']); ?>
    (<a href="logout.php">Logout</a>)
    <hr>
</div>