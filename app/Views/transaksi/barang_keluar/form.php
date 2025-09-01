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
                    <a href="<?= site_url('transaksi/keluar') ?>" class="btn btn-secondary btn-sm">
                        <i class="las la-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form
                        action="<?= isset($barangKeluar) ? site_url('transaksi/keluar/update/' . $barangKeluar['id']) : site_url('transaksi/keluar/store') ?>"
                        method="POST">
                        <?= csrf_field() ?>

                        <!-- Tanggal Keluar -->
                        <div class="mb-3">
                            <label for="tanggal_keluar" class="form-label fw-bold">Tanggal Keluar</label>
                            <input type="date" class="form-control" name="tanggal_keluar" id="tanggal_keluar"
                                value="<?= isset($barangKeluar) ? $barangKeluar['tanggal_keluar'] : date('Y-m-d') ?>"
                                required>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"
                                placeholder="Masukkan keterangan..."
                                required><?= isset($barangKeluar) ? $barangKeluar['keterangan'] : '' ?></textarea>
                        </div>

                        <hr>

                        <!-- Detail Barang Keluar -->
                        <h5 class="mb-3">Detail Barang</h5>
                        <div id="barang-list">
                            <?php if (isset($detail) && !empty($detail)): ?>
                                <?php foreach ($detail as $d): ?>
                                    <div class="row mb-2 barang-item align-items-end p-2 border rounded bg-light">
                                        <div class="col-md-6">
                                            <label>Nama Barang</label><br>
                                            <button type="button" class="btn btn-outline-primary btn-sm btn-open-modal">
                                                Pilih Barang
                                            </button>
                                            <input type="hidden" name="id_barang[]" class="selected-barang-id"
                                                value="<?= $d['id_barang'] ?>">
                                            <div class="selected-barang-name mt-1 fw-bold text-primary">
                                                <?= $d['nama_barang'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control jumlah-barang" min="1"
                                                max="<?= $d['stok_tersedia'] ?>" value="<?= $d['jumlah'] ?>" required>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button type="button" class="btn btn-danger btn-remove"><i
                                                    class="las la-trash"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else: ?>
                                <!-- default baris kosong -->
                                <div class="row mb-2 barang-item align-items-end p-2 border rounded bg-light">
                                    <div class="col-md-6">
                                        <label>Nama Barang</label><br>
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-open-modal">
                                            Pilih Barang
                                        </button>
                                        <input type="hidden" name="id_barang[]" class="selected-barang-id">
                                        <div class="selected-barang-name mt-1 fw-bold text-primary"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Jumlah</label>
                                        <input type="number" name="jumlah[]" class="form-control jumlah-barang" min="1"
                                            required>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-danger btn-remove"><i
                                                class="las la-trash"></i></button>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>

                        <button type="button" id="add-barang" class="btn btn-success mb-3">
                            <i class="las la-plus"></i> Tambah Barang
                        </button>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="las la-save"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Barang -->
<div class="modal fade" id="barangModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Barang</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table id="table-barang" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barang as $b): ?>
                            <tr>
                                <td><?= $b['nama_barang'] ?></td>
                                <td><?= $b['kategori'] ?></td>
                                <td><?= $b['jumlah_stok'] ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm btn-select-barang"
                                        data-id="<?= $b['id'] ?>" data-nama="<?= $b['nama_barang'] ?>"
                                        data-stok="<?= $b['jumlah_stok'] ?>">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {

        // ===== Inisialisasi DataTable =====
        $('#table-barang').DataTable({
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

        let currentRow;
        let barangTerpilih = [];

        // Inisialisasi array barangTerpilih dari baris existing
        $('.selected-barang-id').each(function () {
            let id = $(this).val();
            if (id) barangTerpilih.push(id);
        });

        // Buka modal
        $(document).on('click', '.btn-open-modal', function () {
            currentRow = $(this).closest('.barang-item');
            $('#table-barang tbody tr').show();
            $('#table-barang tbody tr').each(function () {
                let id = $(this).find('.btn-select-barang').data('id').toString();
                if (barangTerpilih.includes(id)) $(this).hide();
            });
            $('#barangModal').modal('show');
        });

        // Pilih barang dari modal
        $(document).on('click', '.btn-select-barang', function () {
            let id = $(this).data('id').toString();
            let nama = $(this).data('nama');
            let stok = $(this).data('stok');

            currentRow.find('.selected-barang-id').val(id);
            currentRow.find('.selected-barang-name').text(nama).addClass('fw-bold text-primary');
            currentRow.find('input.jumlah-barang').attr('max', stok).val(1);

            barangTerpilih.push(id);
            $('#barangModal').modal('hide');
        });

        // Tambah baris baru
        $('#add-barang').click(function () {
            let newItem = $('.barang-item:first').clone();
            newItem.find('input').val('');
            newItem.find('.selected-barang-name').text('').removeClass('fw-bold text-primary');
            $('#barang-list').append(newItem);
        });

        // Hapus baris
        $(document).on('click', '.btn-remove', function () {
            if ($('.barang-item').length > 1) {
                let id = $(this).closest('.barang-item').find('.selected-barang-id').val();
                if (id) {
                    barangTerpilih = barangTerpilih.filter(item => item != id);
                }
                $(this).closest('.barang-item').remove();
            } else {
                ResultToast.fire({
                    icon: 'warning',
                    title: 'Minimal harus ada 1 barang.'
                });
            }
        });

        // Validasi real-time saat mengetik jumlah
        $(document).on('input', 'input.jumlah-barang', function () {
            let max = parseInt($(this).attr('max'));
            let val = parseInt($(this).val());

            if (val > max) {
                $(this).val(max); // reset ke jumlah maksimal
                ResultToast.fire({
                    icon: 'error',
                    title: 'Jumlah barang keluar tidak boleh melebihi stok!'
                });
            } else if (val < 1 || isNaN(val)) {
                $(this).val(1); // minimal 1
            }
        });

        // Validasi sebelum submit
        $('form').submit(function () {
            let valid = true;
            $('.barang-item').each(function () {
                let jumlah = parseInt($(this).find('input.jumlah-barang').val());
                let max = parseInt($(this).find('input.jumlah-barang').attr('max'));
                if (!$(this).find('.selected-barang-id').val() || jumlah > max) {
                    valid = false;
                }
            });

            if (!valid) {
                ResultToast.fire({
                    icon: 'error',
                    title: 'Jumlah barang keluar tidak boleh melebihi stok!'
                });
                return false;
            }
        });

    });
</script>
<?= $this->endSection() ?>