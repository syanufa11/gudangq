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
                    <a href="<?= site_url('transaksi/keluar/create') ?>" class="btn btn-primary btn-sm">
                        <i class="las la-plus"></i> Tambah Barang Keluar
                    </a>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="tabel_barang_keluar" class="table table-hover align-middle w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th><i class="fas fa-calendar mr-1"></i>Tanggal Keluar</th>
                                    <th><i class="fas fa-box mr-1"></i>Barang</th>
                                    <th class="d-none">Kategori</th>
                                    <th class="text-right"><i class="fas fa-hashtag mr-1"></i>Total Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($barangKeluar as $bk): ?>
                                    <?php
                                    $allBarang = array_map(fn($d) => $d['nama_barang'], $bk['detail']);
                                    $allKategori = array_map(fn($d) => $d['kategori'] ?? '-', $bk['detail']);
                                    $totalJumlah = array_sum(array_column($bk['detail'], 'jumlah'));
                                    ?>
                                    <tr
                                        data-detail='<?= htmlspecialchars(json_encode($bk['detail']), ENT_QUOTES, 'UTF-8') ?>'>
                                        <td><?= $no++; ?>.</td>
                                        <td><?= tgl_indo($bk['tanggal_keluar']) ?></td>
                                        <td class="icon-toggle">
                                            <i class="fas fa-plus-circle text-primary"></i> Klik untuk lihat barang
                                        </td>
                                        <td class="d-none"><?= implode(', ', $allKategori) ?></td>
                                        <td class="text-right"><?= number_format($totalJumlah) ?></td>
                                        <td><?= esc($bk['keterangan']) ?></td>
                                        <td>
                                            <a href="<?= site_url('transaksi/keluar/detail/' . $bk['id']) ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="las la-eye"></i> Detail
                                            </a>
                                            <a href="<?= site_url('transaksi/keluar/edit/' . $bk['id']) ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="las la-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-danger"
                                                onclick="hapusData(<?= $bk['id'] ?>, '<?= site_url('transaksi/keluar/delete/') ?>', 'Transaksi Barang Keluar')">
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
        var table = $('#tabel_barang_keluar').DataTable({
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
        $('#tabel_barang_keluar tbody').on('click', 'td.icon-toggle i', function (e) {
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
    });
</script>
<?= $this->endSection() ?>