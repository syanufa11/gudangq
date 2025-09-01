<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title"><?= $title ?></h4>
                    <a href="<?= site_url('pembelian/create') ?>" class="btn btn-primary btn-sm">
                        <i class="las la-plus"></i> Tambah Pembelian
                    </a>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100" id="tabel_pembelian">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:30px;"></th> <!-- ikon expand/collapse -->
                                    <th>No.</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Vendor</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($pembelian as $p): ?>
                                    <tr
                                        data-detail='<?= htmlspecialchars(json_encode($p['barang']), ENT_QUOTES, 'UTF-8') ?>'>
                                        <td class="text-center icon-toggle">
                                            <i class="fas fa-plus-circle text-primary"></i>
                                        </td>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($p['nama_pembeli']) ?></td>
                                        <td><?= esc($p['nama_vendor']) ?></td>
                                        <td><?= tgl_indo($p['tanggal_pembelian']) ?></td>
                                        <td>
                                            <a href="<?= site_url('pembelian/detail/' . $p['id']) ?>"
                                                class="btn btn-info btn-sm">
                                                <i class="las la-eye"></i> Detail
                                            </a>
                                            <a href="<?= site_url('pembelian/edit/' . $p['id']) ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="las la-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-danger"
                                                onclick="hapusData(<?= $p['id'] ?>, '<?= site_url('pembelian/delete') ?>', 'Pembelian')">
                                                <i class="las la-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
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
        var table = $('#tabel_pembelian').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
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
                },
                aria: {
                    sortAscending: ": aktifkan untuk mengurutkan kolom ascending",
                    sortDescending: ": aktifkan untuk mengurutkan kolom descending"
                }
            }
        });

        // Klik ikon toggle untuk expand/collapse
        $('#tabel_pembelian tbody').on('click', 'td.icon-toggle i', function (e) {
            e.stopPropagation();
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                $(this).removeClass('fa-minus-circle text-danger').addClass('fa-plus-circle text-primary');
            } else {
                var detail = tr.data('detail');
                var html = '<ul style="padding-left:15px; margin:0;">';
                detail.forEach(function (item) {
                    html += '<li>' + item.nama_barang + ' - ' + item.total_barang + ' pcs - Rp ' +
                        Number(item.total_harga).toLocaleString('id-ID') + '</li>';
                });
                html += '</ul>';

                row.child(html).show();
                $(this).removeClass('fa-plus-circle text-primary').addClass('fa-minus-circle text-danger');
            }
        });
    });
</script>
<?= $this->endSection() ?>