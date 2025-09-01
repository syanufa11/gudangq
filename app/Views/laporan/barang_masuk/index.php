<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between align-items-center">
                    <div class="iq-header-title">
                        <h4 class="card-title"><?= $title ?></h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <form id="formFilterMasuk" method="GET" action="<?= site_url('laporan/masuk') ?>" class="mb-3">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="dari" class="form-label">Dari Tanggal</label>
                                <input type="date" name="dari" id="dariMasuk" class="form-control"
                                    value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="sampai" class="form-label">Sampai Tanggal</label>
                                <input type="date" name="sampai" id="sampaiMasuk" class="form-control"
                                    value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>

                            <div class="col-md-2">
                                <a href="<?= site_url('laporan/masuk') ?>" class="btn btn-secondary w-100">Clear
                                    Filter</a>
                            </div>

                            <div class="col-md-4 text-end mt-3">
                                <a href="<?= site_url('laporan/masuk/export/excel?' . $_SERVER['QUERY_STRING']) ?>"
                                    class="btn btn-success export-masuk" data-type="Excel">
                                    <i class="las la-file-excel"></i> Excel
                                </a>
                                <a href="<?= site_url('laporan/masuk/export/pdf?' . $_SERVER['QUERY_STRING']) ?>"
                                    class="btn btn-danger export-masuk" data-type="PDF">
                                    <i class="las la-file-pdf"></i> PDF
                                </a>
                                <a href="<?= site_url('laporan/masuk/export/word?' . $_SERVER['QUERY_STRING']) ?>"
                                    class="btn btn-warning export-masuk" data-type="Word">
                                    <i class="las la-file-word"></i> Word
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="tabel_barang_masuk" class="table table-hover align-middle w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th><i class="fas fa-calendar mr-1"></i>Tanggal Masuk</th>
                                    <th><i class="fas fa-store mr-1"></i>Vendor</th>
                                    <th><i class="fas fa-box mr-1"></i>Barang</th>
                                    <th class="d-none">Kategori</th> <!-- hidden column -->
                                    <th class="text-right"><i class="fas fa-hashtag mr-1"></i>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($barangMasuk as $bm): ?>
                                    <?php
                                    $allBarang = array_map(fn($b) => $b['nama_barang'], $bm['detail']);
                                    $allKategori = array_map(fn($b) => $b['kategori'] ?? '-', $bm['detail']);
                                    $totalJumlah = array_sum(array_column($bm['detail'], 'jumlah'));
                                    ?>
                                    <tr
                                        data-detail='<?= htmlspecialchars(json_encode($bm['detail']), ENT_QUOTES, 'UTF-8') ?>'>
                                        <td><?= $no++; ?>.</td>
                                        <td><?= tgl_indo($bm['tanggal_masuk']) ?></td>
                                        <td><?= esc($bm['nama_vendor']) ?></td>
                                        <td class="icon-toggle">
                                            <i class="fas fa-plus-circle text-primary"></i> Klik untuk lihat barang
                                        </td>
                                        <td class="d-none"><?= implode(', ', $allKategori) ?></td>
                                        <td class="text-right"><?= number_format($totalJumlah) ?></td>
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        var table = $('#tabel_barang_masuk').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            autoWidth: false,
            language: {
                decimal: ",",
                thousands: ".",
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(difilter dari _MAX_ total entri)",
                loadingRecords: "Memuat...",
                processing: "Memproses...",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data tersedia",
                paginate: {
                    first: "Pertama",
                    previous: "Sebelumnya",
                    next: "Berikutnya",
                    last: "Terakhir"
                }
            }
        });

        // Expand/collapse barang
        $('#tabel_barang_masuk tbody').on('click', 'td.icon-toggle i', function (e) {
            e.stopPropagation();
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                $(this).removeClass('fa-minus-circle text-danger').addClass('fa-plus-circle text-primary');
            } else {
                var detail = tr.data('detail');
                if (typeof detail === "string") detail = JSON.parse(detail);

                var html = '<ul style="padding-left:15px; margin:0;">';
                detail.forEach(function (item) {
                    html += '<li>'
                        + '<span class="badge badge-light">' + item.nama_barang + '</span> - '
                        + item.jumlah + ' ' + (item.satuan ?? '') + ' - '
                        + '<span class="badge badge-dark">' + (item.nama_kategori ?? '-') + '</span>'
                        + '</li>';
                });
                html += '</ul>';

                row.child(html).show();
                $(this).removeClass('fa-plus-circle text-primary').addClass('fa-minus-circle text-danger');
            }
        });

        // Validasi Filter Form Barang Masuk
        $('#formFilterMasuk').on('submit', function (e) {
            var dari = $('#dariMasuk').val();
            var sampai = $('#sampaiMasuk').val();

            if (!dari || !sampai) {
                e.preventDefault();
                ResultToast.fire({
                    icon: 'error',
                    title: 'Silakan pilih tanggal dari dan sampai terlebih dahulu!'
                });
            }
        });

        // Validasi Export Barang Masuk
        $('.export-masuk').on('click', function (e) {
            var dari = $('#dariMasuk').val();
            var sampai = $('#sampaiMasuk').val();

            if (!dari || !sampai) {
                e.preventDefault();
                ResultToast.fire({
                    icon: 'error',
                    title: 'Silakan pilih tanggal dari dan sampai terlebih dahulu sebelum export ' + $(this).data('type') + '!'
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>