<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary mb-1"><?= $title ?></h2>
                    <p class="text-muted mb-0">Detail informasi pembelian dan daftar barang</p>
                </div>
                <div class="btn-group-custom">
                    <a href="<?= site_url('pembelian') ?>" class="btn btn-secondary">
                        <i class="las la-arrow-left mr-1"></i> Kembali
                    </a>
                    <a href="<?= site_url('pembelian/cetak_pdf/' . $pembelian['id']) ?>" target="_blank"
                        class="btn btn-primary">
                        <i class="las la-print mr-1"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Info Cards -->
    <div class="row mb-2">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="icon-circle bg-primary-light mb-3">
                        <i class="las la-store text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="text-muted mb-2">Vendor</h6>
                    <h5 class="mb-0 text-dark font-weight-bold"><?= $pembelian['nama_vendor'] ?></h5>
                    <small class="text-muted d-block mt-1"><?= $pembelian['alamat_vendor'] ?></small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="icon-circle bg-success-light mb-3">
                        <i class="las la-user text-success" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="text-muted mb-2">Pembeli</h6>
                    <h5 class="mb-0 text-dark font-weight-bold"><?= $pembelian['nama_pembeli'] ?></h5>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="icon-circle bg-info-light mb-3">
                        <i class="las la-calendar text-info" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="text-muted mb-2">Tanggal Pembelian</h6>
                    <h5 class="mb-0 text-dark font-weight-bold"><?= tgl_indo($pembelian['tanggal_pembelian']) ?></h5>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="icon-circle bg-warning-light mb-3">
                        <i class="las la-shopping-cart text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="text-muted mb-2">Total Items</h6>
                    <h5 class="mb-0 text-dark font-weight-bold"><?= count($detail) ?> Produk</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-4">
                    <h5 class="mb-0">
                        <i class="las la-list-alt text-primary mr-2"></i>
                        Daftar Barang Pembelian
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tabel_pembelian">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">No.</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-right">Harga Satuan</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $totalHarga = 0;
                                ?>
                                <?php foreach ($detail as $d):
                                    $subtotal = $d['harga'] * $d['jumlah'];
                                    $totalHarga += $subtotal;
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge badge-light text-dark"><?= $no++ ?></span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary"><?= $d['kode_barang'] ?></span>
                                        </td>
                                        <td class="font-weight-bold"><?= $d['nama_barang'] ?></td>
                                        <td>
                                            <span class="badge badge-secondary"><?= $d['nama_kategori'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info"><?= $d['jumlah'] ?></span>
                                        </td>
                                        <td class="text-right text-muted">
                                            Rp <?= number_format($d['harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-right font-weight-bold text-success">
                                            Rp <?= number_format($subtotal, 0, ',', '.') ?>
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

    <!-- Total Summary -->
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="text-white mb-0">
                                <i class="las la-calculator mr-2"></i>
                                Total Keseluruhan Pembelian
                            </h5>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <h3 class="text-white mb-0 font-weight-bold">
                                Rp <?= number_format($totalHarga, 0, ',', '.') ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        $('#tabel_pembelian').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            pageLength: 10,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                decimal: ",",
                thousands: ".",
                search: "Cari produk:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ produk",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 produk",
                infoFiltered: "(difilter dari _MAX_ total produk)",
                loadingRecords: "Memuat data...",
                processing: "Memproses data...",
                zeroRecords: "Tidak ditemukan produk yang sesuai",
                emptyTable: "Tidak ada data produk tersedia",
                paginate: {
                    first: "Pertama",
                    previous: "Sebelumnya",
                    next: "Berikutnya",
                    last: "Terakhir"
                },
                aria: {
                    sortAscending: ": aktifkan untuk mengurutkan kolom ascending",
                    sortDescending: ": aktifkan untuk mengurutkan kolom descending"
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