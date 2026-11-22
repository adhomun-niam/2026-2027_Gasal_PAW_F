CREATE DATABASE IF NOT EXISTS db_modul8 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_modul8;


CREATE TABLE user (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,              
    nama     VARCHAR(100) NOT NULL,
    alamat   VARCHAR(255) DEFAULT NULL,
    hp       VARCHAR(20)  DEFAULT NULL,
    level    TINYINT      NOT NULL DEFAULT 2     
) ENGINE=InnoDB;

CREATE TABLE supplier (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nama   VARCHAR(100) NOT NULL,
    telp   VARCHAR(20)  DEFAULT NULL,
    alamat VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE barang (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(20)  NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    harga       INT NOT NULL DEFAULT 0,
    stok        INT NOT NULL DEFAULT 0,
    supplier_id INT NOT NULL,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id)
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
    id            VARCHAR(10) PRIMARY KEY,       
    nama          VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    telp          VARCHAR(20)  DEFAULT NULL,
    alamat        VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE transaksi (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan      VARCHAR(255) DEFAULT NULL,
    total           INT NOT NULL DEFAULT 0,
    pelanggan_id    VARCHAR(10) NOT NULL,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id    INT NOT NULL,
    harga        INT NOT NULL,
    qty          INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (barang_id)    REFERENCES barang(id)
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar  DATETIME NOT NULL,
    total        INT NOT NULL,
    metode       ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO user (id, username, password, nama, alamat, hp, level) VALUES
(1, 'owner', 'owner123', 'Budi', 'Bangkalan', '081200000001', 1),
(2, 'kasir', 'kasir123', 'Wati', 'Bangkalan', '081200000002', 2);

INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT Sumber Makmur', '081234560001', 'Surabaya'),
(2, 'CV Maju Jaya', '081234560002', 'Sidoarjo'),
(3, 'UD Berkah Abadi', '081234560003', 'Gresik'),
(4, 'PT Sinar Terang', '081234560004', 'Malang'),
(5, 'CV Mitra Sejahtera', '081234560005', 'Bangkalan');

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Beras 5 Kg', 65000, 50, 1),
(2, 'BRG002', 'Minyak Goreng 2 L', 38000, 40, 2),
(3, 'BRG003', 'Gula Pasir 1 Kg', 17000, 100, 1),
(4, 'BRG004', 'Telur Ayam 1 Kg', 28000, 60, 3),
(5, 'BRG005', 'Kopi Bubuk 200 g', 15000, 80, 4),
(6, 'BRG006', 'Teh Celup 25 pcs', 9000, 120, 5);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Budi Santoso', 'L', '081300000001', 'Bangkalan'),
('PLG002', 'Siti Aminah', 'P', '081300000002', 'Sampang'),
('PLG003', 'Ahmad Fauzi', 'L', '081300000003', 'Pamekasan'),
('PLG004', 'Dewi Lestari', 'P', '081300000004', 'Sumenep'),
('PLG005', 'Rizky Pratama', 'L', '081300000005', 'Bangkalan'),
('PLG006', 'Nur Hidayah', 'P', '081300000006', 'Surabaya');

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-11-01', 'Belanja harian', 43000, 'PLG001'),
(2, '2026-11-01', 'Belanja bulanan', 65000, 'PLG002'),
(3, '2026-11-02', 'Belanja harian', 68000, 'PLG001'),
(4, '2026-11-03', 'Belanja harian', 55000, 'PLG003'),
(5, '2026-11-03', 'Belanja harian', 32000, 'PLG004'),
(6, '2026-11-05', 'Belanja harian', 56000, 'PLG002'),
(7, '2026-11-05', 'Belanja bulanan', 103000, 'PLG005'),
(8, '2026-11-06', 'Belanja harian', 48000, 'PLG006'),
(9, '2026-11-08', 'Belanja harian', 55000, 'PLG003'),
(10, '2026-11-08', 'Belanja bulanan', 130000, 'PLG001'),
(11, '2026-11-10', 'Belanja harian', 62000, 'PLG004'),
(12, '2026-11-10', 'Belanja harian', 45000, 'PLG005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 3, 17000, 2),
(1, 6, 9000, 1),
(2, 1, 65000, 1),
(3, 2, 38000, 1),
(3, 5, 15000, 2),
(4, 4, 28000, 1),
(4, 6, 9000, 3),
(5, 3, 17000, 1),
(5, 5, 15000, 1),
(6, 4, 28000, 2),
(7, 1, 65000, 1),
(7, 2, 38000, 1),
(8, 5, 15000, 2),
(8, 6, 9000, 2),
(9, 2, 38000, 1),
(9, 3, 17000, 1),
(10, 1, 65000, 2),
(11, 3, 17000, 2),
(11, 4, 28000, 1),
(12, 5, 15000, 3);

INSERT INTO pembayaran (id, waktu_bayar, total, metode, transaksi_id) VALUES
(1, '2026-11-01 09:10:00', 43000, 'TUNAI', 1),
(2, '2026-11-01 11:25:00', 65000, 'TRANSFER', 2),
(3, '2026-11-02 10:05:00', 68000, 'EDC', 3),
(4, '2026-11-03 08:45:00', 55000, 'TUNAI', 4),
(5, '2026-11-03 14:30:00', 32000, 'TUNAI', 5),
(6, '2026-11-05 09:50:00', 56000, 'TRANSFER', 6),
(7, '2026-11-05 13:15:00', 103000, 'EDC', 7),
(8, '2026-11-06 15:40:00', 48000, 'TUNAI', 8),
(9, '2026-11-08 10:20:00', 55000, 'TUNAI', 9),
(10, '2026-11-08 16:00:00', 130000, 'TRANSFER', 10),
(11, '2026-11-10 09:30:00', 62000, 'EDC', 11),
(12, '2026-11-10 12:10:00', 45000, 'TUNAI', 12);