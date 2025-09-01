<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Barang Keluar - <?= $barangKeluar['keterangan'] ?? 'Barang Keluar' ?></title>
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

        .summary-section {
            border: 2px solid #2c3e50;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .summary-label {
            font-weight: bold;
            color: #2c3e50;
        }

        .summary-value {
            font-weight: bold;
            font-size: 14px;
            color: #c0392b;
        }

        .total-row {
            border-top: 2px solid #2c3e50;
            padding-top: 10px;
            margin-top: 5px;
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
                <div class="title">Detail Barang Keluar</div>
                <div class="subtitle">Dokumen Transaksi Barang Keluar</div>
            </div>
        </div>

        <!-- Info Barang Keluar -->
        <div class="info-section">
            <h3>Informasi Barang Keluar</h3>
            <div class="info-grid">
                <div>
                    <div class="info-item"><span class="info-label">Tanggal Keluar:</span>
                        <span
                            class="info-value font-weight-bold"><?= tgl_indo($barangKeluar['tanggal_keluar']) ?></span>
                    </div>
                    <div class="info-item"><span class="info-label">Keterangan:</span>
                        <span class="info-value"><?= $barangKeluar['keterangan'] ?? '-' ?></span>
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

        <!-- Table Barang Keluar -->
        <div class="table-section">
            <h3>Rincian Barang Keluar</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th class="text-center">Jumlah Keluar</th>
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