<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary mb-1"><?= $title ?></h2>
                    <p class="text-muted mb-0">Detail informasi barang keluar dan daftar item</p>
                </div>
                <div class="btn-group-custom">
                    <a href="<?= site_url('transaksi/keluar') ?>" class="btn btn-secondary">
                        <i class="las la-arrow-left mr-1"></i> Kembali
                    </a>
                    <a href="<?= site_url('transaksi/keluar/cetak_pdf/' . $barangKeluar['id']) ?>" target="_blank"
                        class="btn btn-primary">
                        <i class="las la-print mr-1"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-2">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="icon-circle bg-info-light mb-3">
                        <i class="las la-calendar text-info" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="text-muted mb-2">Tanggal Keluar</h6>
                    <h5 class="mb-0 text-dark font-weight-bold"><?= tgl_indo($barangKeluar['tanggal_keluar']) ?></h5>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="icon-circle bg-success-light mb-3">
                        <i class="las la-info-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="text-muted mb-2">Keterangan</h6>
                    <h5 class="mb-0 text-dark font-weight-bold"><?= $barangKeluar['keterangan'] ?? '-' ?></h5>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="icon-circle bg-warning-light mb-3">
                        <i class="las la-box text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="text-muted mb-2">Total Items</h6>
                    <h5 class="mb-0 text-dark font-weight-bold"><?= count($detail) ?> Produk</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-4">
                    <h5 class="mb-0">
                        <i class="las la-list-alt text-primary mr-2"></i>
                        Daftar Barang Keluar
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tabel_keluar">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">No.</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-right">Stok Tersedia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $totalJumlah = 0;
                                ?>

                                <?php foreach ($detail as $d):
                                    $totalJumlah += $d['jumlah'];
                                    ?>
                                    <tr>
                                        <td class="text-center"><span
                                                class="badge badge-light text-dark"><?= $no++ ?></span></td>
                                        <td><span class="badge badge-primary"><?= $d['kode_barang'] ?? '-' ?></span></td>
                                        <td class="font-weight-bold"><?= $d['nama_barang'] ?? '-' ?></td>
                                        <td><span class="badge badge-secondary"><?= $d['nama_kategori'] ?? '-' ?></span>
                                        </td>
                                        <td class="text-center"><?= $d['satuan'] ?? '-' ?></td>
                                        <td class="text-center"><span class="badge badge-info"><?= $d['jumlah'] ?></span>
                                        </td>
                                        <td class="text-right font-weight-bold text-success"><?= $d['jumlah_stok'] ?? 0 ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reuse styles dari halaman pembelian -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        $('#tabel_keluar').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            pageLength: 10,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                search: "Cari produk:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ produk",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 produk",
                infoFiltered: "(difilter dari _MAX_ total produk)",
                zeroRecords: "Tidak ditemukan produk yang sesuai",
                emptyTable: "Tidak ada data produk tersedia",
                paginate: {
                    first: "Pertama",
                    previous: "Sebelumnya",
                    next: "Berikutnya",
                    last: "Terakhir"
                }
            },
            columnDefs: [
                { orderable: false, targets: 0 }
            ]
        });

        // Add fade-in animation
        $('.card').each(function (index) {
            $(this).css('opacity', '0').delay(index * 100).animate({ opacity: 1 }, 500);
        });
    });
</script>
<?= $this->endSection() ?>