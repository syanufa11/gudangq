<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Barang Masuk - <?= $barangMasuk['nama_vendor'] ?? 'Barang Masuk' ?></title>
    <link rel="shortcut icon"
        href="<?= isset($aplikasi['logo']) ? base_url($aplikasi['logo']) : base_url('template/html/images/logo.png') ?>" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #000;
            line-height: 1.5;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .title-container {
            text-align: center;
            flex-grow: 1;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 13px;
            font-style: italic;
            color: #7f8c8d;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-section h3 {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #34495e;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 5px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            display: inline-block;
        }

        .info-value {
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #bdc3c7;
            padding: 8px;
            font-size: 11px;
        }

        th {
            background: #ecf0f1;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 10mm;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="title-container">
                <div class="title">Detail Barang Masuk</div>
                <div class="subtitle">Dokumen Transaksi Barang Masuk</div>
            </div>
        </div>

        <!-- Info Barang Masuk -->
        <div class="info-section">
            <h3>Informasi Barang Masuk</h3>
            <div class="info-grid">
                <div>
                    <div class="info-item"><span class="info-label">Tanggal Masuk:</span>
                        <span class="info-value font-weight-bold"><?= tgl_indo($barangMasuk['tanggal_masuk']) ?></span>
                    </div>
                    <div class="info-item"><span class="info-label">Vendor:</span>
                        <span class="info-value"><?= $barangMasuk['nama_vendor'] ?? '-' ?></span>
                    </div>
                </div>
                <div>
                    <div class="info-item"><span class="info-label">Total Items:</span>
                        <span class="info-value font-weight-bold"><?= count($detail) ?> Produk</span>
                    </div>
                    <div class="info-item"><span class="info-label">Total Quantity:</span>
                        <span class="info-value font-weight-bold"><?= array_sum(array_column($detail, 'jumlah')) ?>
                            Unit</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Barang Masuk -->
        <div class="table-section">
            <h3>Rincian Barang Masuk</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th class="text-center">Jumlah Masuk</th>
                        <th class="text-center">Stok Tersedia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($detail as $d): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center font-weight-bold"><?= $d['kode_barang'] ?? '-' ?></td>
                            <td><?= $d['nama_barang'] ?? '-' ?></td>
                            <td class="text-center"><?= $d['satuan'] ?? '-' ?></td>
                            <td class="text-center"><?= $d['nama_kategori'] ?? '-' ?></td>
                            <td class="text-center"><?= $d['jumlah'] ?></td>
                            <td class="text-center"><?= $d['jumlah_stok'] ?? 0 ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>Catatan: Dokumen dicetak otomatis pada <?= tgl_indo(date('Y-m-d')) ?> pukul <?= date('H:i') ?> WIB
            </div>
            <div style="margin-top:5px; font-size:10px; color:#7f8c8d;">
                Aplikasi: <?= isset($aplikasi['nama']) ? $aplikasi['nama'] : 'Server' ?>
            </div>
        </div>
    </div>
</body>

</html>