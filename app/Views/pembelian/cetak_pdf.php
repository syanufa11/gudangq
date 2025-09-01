<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pembelian - <?= $pembelian['nama_vendor'] ?></title>
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

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
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

        /* Document Info */
        .document-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 11px;
            background: #ecf0f1;
            padding: 10px 15px;
            border-radius: 5px;
        }

        /* Info Section */
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

        /* Stats Section */
        .stats-section {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-item {
            flex: 1;
            background: #3498db;
            color: #fff;
            padding: 12px;
            text-align: center;
            border-radius: 6px;
            position: relative;
        }

        .stat-item .icon {
            font-size: 20px;
            position: absolute;
            top: 8px;
            left: 10px;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
        }

        /* Table Section */
        .table-section h3 {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #34495e;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 5px;
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

        .text-right {
            text-align: right;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        /* Summary */
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

        /* Signature */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            gap: 50px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 60px;
            text-transform: uppercase;
        }

        .signature-name {
            border-top: 1px solid #000;
            padding-top: 5px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 10mm;
            width: 100%;
        }

        /* Print */
        @media print {
            body {
                padding: 10px;
            }

            .header,
            .table-section,
            .signature-section {
                page-break-inside: avoid;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }

        @page {
            size: A4;
            margin: 20mm;

            @bottom-right {
                content: "Halaman " counter(page) " dari " counter(pages);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="title-container">
                <div class="title">Detail Pembelian</div>
                <div class="subtitle">Dokumen Transaksi Pembelian Barang</div>
            </div>
        </div>

        <!-- Purchase Info -->
        <div class="info-section">
            <h3>Informasi Pembelian</h3>
            <div class="info-grid">
                <div>
                    <div class="info-item"><span class="info-label">Nama Vendor:</span> <span
                            class="info-value font-weight-bold"><?= $pembelian['nama_vendor'] ?></span></div>
                    <div class="info-item"><span class="info-label">Alamat Vendor:</span> <span
                            class="info-value"><?= $pembelian['alamat_vendor'] ?></span></div>
                </div>
                <div>
                    <div class="info-item"><span class="info-label">Nama Pembeli:</span> <span
                            class="info-value font-weight-bold"><?= $pembelian['nama_pembeli'] ?></span></div>
                    <div class="info-item"><span class="info-label">Tanggal Transaksi:</span> <span
                            class="info-value font-weight-bold"><?= tgl_indo($pembelian['tanggal_pembelian']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-section">
            <h3>Rincian Barang</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $totalHarga = 0;
                    foreach ($detail as $d):
                        $subtotal = $d['harga'] * $d['jumlah'];
                        $totalHarga += $subtotal; ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center font-weight-bold"><?= $d['kode_barang'] ?></td>
                            <td><?= $d['nama_barang'] ?></td>
                            <td class="text-center"><?= $d['nama_kategori'] ?></td>
                            <td class="text-center"><?= $d['jumlah'] ?></td>
                            <td class="text-right">Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                            <td class="text-right font-weight-bold" style="color:#c0392b;">Rp
                                <?= number_format($subtotal, 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="summary-section">
            <div class="summary-row"><span class="summary-label">Jumlah Item:</span> <span><?= count($detail) ?>
                    Produk</span></div>
            <div class="summary-row"><span class="summary-label">Total Quantity:</span>
                <span><?= array_sum(array_column($detail, 'jumlah')) ?> Unit</span>
            </div>
            <div class="summary-row total-row"><span class="summary-label">TOTAL PEMBELIAN:</span> <span
                    class="summary-value">Rp <?= number_format($totalHarga, 0, ',', '.') ?></span></div>
        </div>



        <!-- Footer -->
        <!-- Footer -->
        <div class="footer">
            <div>Catatan: Dokumen dicetak otomatis pada <?= tgl_indo(date('Y-m-d')) ?> pukul <?= date('H:i') ?> WIB
            </div>
            <div style="margin-top:5px; font-size:10px; color:#7f8c8d; display:flex; align-items:center; gap:5px;">
                <span>Aplikasi: <?= isset($aplikasi['nama']) ? $aplikasi['nama'] : 'Server' ?></span>
            </div>
        </div>


        <!-- Script PHP untuk nomor halaman -->


    </div>

</body>

</html>