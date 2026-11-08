CREATE DATABASE IF NOT EXISTS penjualan_modul6
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE penjualan_modul6;

DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS `user`;


CREATE TABLE supplier (
  id     INT          NOT NULL AUTO_INCREMENT,
  nama   VARCHAR(100) NOT NULL,
  telp   VARCHAR(12)  DEFAULT NULL,
  alamat TEXT,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
  id            VARCHAR(20)  NOT NULL,
  nama          VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp          VARCHAR(12)  DEFAULT NULL,
  alamat        TEXT,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE barang (
  id          INT          NOT NULL AUTO_INCREMENT,
  kode_barang VARCHAR(10)  NOT NULL,
  nama_barang VARCHAR(100) NOT NULL,
  harga       INT          NOT NULL,
  stok        INT          NOT NULL,
  supplier_id INT          NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uk_kode_barang (kode_barang),
  CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id)
    REFERENCES supplier (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transaksi (
  id              INT         NOT NULL AUTO_INCREMENT,
  waktu_transaksi DATE        NOT NULL,
  keterangan      TEXT,
  total           INT         NOT NULL DEFAULT 0,
  pelanggan_id    VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id)
    REFERENCES pelanggan (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
  transaksi_id INT NOT NULL,
  barang_id    INT NOT NULL,
  harga        INT NOT NULL,
  qty          INT NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id) REFERENCES barang (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
  id           INT         NOT NULL AUTO_INCREMENT,
  waktu_bayar  DATETIME    NOT NULL,
  total        INT         NOT NULL,
  metode       ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT         NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `user` (
  id_user  TINYINT      NOT NULL AUTO_INCREMENT,
  username VARCHAR(30)  NOT NULL,
  password VARCHAR(35)  NOT NULL,
  nama     VARCHAR(50)  DEFAULT NULL,
  alamat   VARCHAR(150) DEFAULT NULL,
  hp       VARCHAR(20)  DEFAULT NULL,
  level    TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (id_user),
  UNIQUE KEY uk_username (username)
) ENGINE=InnoDB;


INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT Sumber Pangan',   '031555101', 'Jl. Rungkut Industri 12, Surabaya'),
(2, 'CV Maju Jaya',       '031555102', 'Jl. Ahmad Yani 45, Sidoarjo'),
(3, 'UD Berkah Makmur',   '031555103', 'Jl. Raya Bangkalan 8, Bangkalan'),
(4, 'PT Cahaya Niaga',    '031555104', 'Jl. Diponegoro 21, Surabaya'),
(5, 'CV Karya Sejahtera', '031555105', 'Jl. Pemuda 77, Gresik');

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Budi Santoso',   'L', '081234500001', 'Jl. Mawar 3, Bangkalan'),
('PLG002', 'Siti Aminah',    'P', '081234500002', 'Jl. Melati 10, Bangkalan'),
('PLG003', 'Rudi Hartono',   'L', '081234500003', 'Jl. Kenanga 5, Sampang'),
('PLG004', 'Dewi Lestari',   'P', '081234500004', 'Jl. Anggrek 17, Pamekasan'),
('PLG005', 'Agus Setiawan',  'L', '081234500005', 'Jl. Cempaka 9, Sumenep');

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Beras Premium 5kg', 68000, 50, 1),
(2, 'BRG002', 'Minyak Goreng 2L',  38000, 40, 1),
(3, 'BRG003', 'Gula Pasir 1kg',    17000, 60, 2),
(4, 'BRG004', 'Kopi Bubuk 200g',   22000, 35, 2),
(5, 'BRG005', 'Teh Celup 25s',      9000, 80, 3),
(6, 'BRG006', 'Susu UHT 1L',       18000, 45, 3),
(7, 'BRG007', 'Sabun Mandi',        8000, 70, 4),
(8, 'BRG008', 'Shampoo 100ml',     15000, 55, 5);

INSERT INTO `user` (id_user, username, password, nama, alamat, hp, level) VALUES
(1, 'admin',  MD5('admin123'),  'Administrator', 'Bangkalan', '081300000001', 1),
(2, 'kasir1', MD5('kasir123'),  'Kasir Satu',    'Bangkalan', '081300000002', 2),
(3, 'kasir2', MD5('kasir123'),  'Kasir Dua',     'Surabaya',  '081300000003', 2),
(4, 'gudang', MD5('gudang123'), 'Petugas Gudang','Sidoarjo',  '081300000004', 3),
(5, 'owner',  MD5('owner123'),  'Pemilik Toko',  'Surabaya',  '081300000005', 1);


INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1,  '2026-10-01', 'Belanja bulanan',        0, 'PLG001'),
(2,  '2026-10-02', 'Belanja harian',         0, 'PLG002'),
(3,  '2026-10-04', 'Beli teh',               0, 'PLG003'),
(4,  '2026-10-06', 'Belanja keluarga',       0, 'PLG004'),
(5,  '2026-10-08', 'Stok warung',            0, 'PLG005'),
(6,  '2026-10-10', 'Belanja kopi dan susu',  0, 'PLG001'),
(7,  '2026-10-12', 'Belanja mingguan',       0, 'PLG002'),
(8,  '2026-10-15', 'Beli minyak',            0, 'PLG003'),
(9,  '2026-10-18', 'Belanja sarapan',        0, 'PLG004'),
(10, '2026-10-20', 'Belanja acara kantor',   0, 'PLG005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 68000, 1), (1, 2, 38000, 2),
(2, 3, 17000, 3), (2, 4, 22000, 1),
(3, 5,  9000, 5),
(4, 1, 68000, 2), (4, 6, 18000, 2), (4, 3, 17000, 1),
(5, 2, 38000, 1), (5, 5,  9000, 4),
(6, 4, 22000, 2), (6, 6, 18000, 3),
(7, 1, 68000, 1), (7, 3, 17000, 2), (7, 5, 9000, 2),
(8, 2, 38000, 3),
(9, 6, 18000, 1), (9, 4, 22000, 1),
(10, 3, 17000, 4), (10, 5, 9000, 3), (10, 2, 38000, 1);

UPDATE transaksi t
SET t.total = (SELECT COALESCE(SUM(d.harga * d.qty), 0)
               FROM transaksi_detail d
               WHERE d.transaksi_id = t.id);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-10-01 10:15:00', 0, 'TUNAI',    1),
('2026-10-02 11:30:00', 0, 'TRANSFER', 2),
('2026-10-04 09:45:00', 0, 'TUNAI',    3),
('2026-10-06 14:20:00', 0, 'EDC',      4),
('2026-10-08 16:05:00', 0, 'TUNAI',    5),
('2026-10-10 13:10:00', 0, 'TRANSFER', 6),
('2026-10-12 10:40:00', 0, 'EDC',      7),
('2026-10-15 15:25:00', 0, 'TUNAI',    8),
('2026-10-18 08:50:00', 0, 'TRANSFER', 9),
('2026-10-20 12:00:00', 0, 'EDC',     10);

UPDATE pembayaran p
JOIN transaksi t ON t.id = p.transaksi_id
SET p.total = t.total;