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
                    <a href="<?= site_url('pembelian') ?>" class="btn btn-secondary btn-sm">
                        <i class="las la-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="iq-card-body">
                    <form method="post"
                        action="<?= isset($pembelian) ? site_url('pembelian/update/' . $pembelian['id']) : site_url('pembelian/store') ?>">

                        <!-- Nama Vendor -->
                        <div class="mb-3">
                            <label for="nama_vendor">Nama Vendor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_vendor" id="nama_vendor"
                                value="<?= isset($pembelian) ? $pembelian['nama_vendor'] : '' ?>" required>
                        </div>

                        <!-- Alamat Vendor -->
                        <div class="mb-3">
                            <label for="alamat_vendor">Alamat Vendor <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat_vendor" id="alamat_vendor" rows="2"
                                required><?= isset($pembelian) ? $pembelian['alamat_vendor'] : '' ?></textarea>
                        </div>

                        <!-- Nama Pembeli -->
                        <div class="mb-3">
                            <label for="nama_pembeli">Nama Pembeli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_pembeli" id="nama_pembeli"
                                value="<?= isset($pembelian) ? $pembelian['nama_pembeli'] : '' ?>" required>
                        </div>

                        <!-- Tanggal Pembelian -->
                        <div class="mb-3">
                            <label for="tanggal_pembelian">Tanggal Pembelian <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_pembelian" id="tanggal_pembelian"
                                value="<?= isset($pembelian) ? $pembelian['tanggal_pembelian'] : date('Y-m-d') ?>"
                                required>
                        </div>

                        <!-- Tombol Tambah Barang -->
                        <button type="button" class="btn btn-success mb-3" onclick="openBarangModal()">
                            <i class="las la-plus"></i> Tambah Barang
                        </button>

                        <!-- Tabel Barang Terpilih -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabel_barang_terpilih">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($detail_pembelian)): ?>
                                        <?php foreach ($detail_pembelian as $d): ?>
                                            <tr>
                                                <td>
                                                    <?= $d['nama_barang'] ?>
                                                    <input type="hidden" name="barang_id[]" value="<?= $d['id_barang'] ?>">
                                                </td>
                                                <td><?= $d['satuan'] ?></td>
                                                <td><input type="number" name="jumlah[]" class="form-control"
                                                        value="<?= $d['jumlah'] ?>" min="1"></td>
                                                <td>
                                                    <input type="text" name="harga[]" class="form-control harga"
                                                        value="Rp <?= number_format($d['harga'], 0, ',', '.') ?>"
                                                        data-value="<?= $d['harga'] ?>">
                                                </td>

                                                <td class="subtotal"><?= $d['jumlah'] * $d['harga'] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="hapusBarang(<?= $d['id'] ?>, this)">Hapus</button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                            <!-- Total Keseluruhan -->
                            <div class="mt-3 text-right">
                                <h5>Total Keseluruhan: <span id="grandTotal">Rp 0</span></h5>
                            </div>

                        </div>

                        <!-- Submit -->
                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save"></i> <?= isset($pembelian) ? 'Update' : 'Simpan' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Barang -->
<div class="modal fade" id="barangModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Barang</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tabel_barang_modal">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barang as $b): ?>
                            <tr data-id="<?= $b['id'] ?>">
                                <td><?= $b['nama_barang'] ?></td>
                                <td><?= $b['kode_barang'] ?></td>
                                <td><?= $b['kategori'] ?></td>
                                <td><?= $b['satuan'] ?></td>
                                <td><?= $b['jumlah_stok'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="pilihBarang('<?= $b['id'] ?>','<?= $b['nama_barang'] ?>','<?= $b['satuan'] ?>', this)">
                                        Pilih
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        // DataTable modal barang
        $('#tabel_barang_modal').DataTable({
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

        // DataTable barang terpilih
        window.dtTerpilih = $('#tabel_barang_terpilih').DataTable({
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

        // Update subtotal awal
        updateSubtotal();
    });

    // Modal
    let modalBarang = new bootstrap.Modal(document.getElementById('barangModal'));

    // Array barang yang sudah dipilih
    let barangTerpilih = [];
    <?php if (isset($detail_pembelian)): ?>
        barangTerpilih = [
            <?php foreach ($detail_pembelian as $d): ?>
                                                                                                                            '<?= $d['id_barang'] ?>',
            <?php endforeach; ?>
        ];
    <?php endif; ?>

    // Buka modal
    function openBarangModal() {
        $('#tabel_barang_modal tbody tr').show();
        $('#tabel_barang_modal tbody tr').each(function () {
            let id = $(this).data('id').toString();
            if (barangTerpilih.includes(id)) $(this).hide();
        });
        modalBarang.show();
    }

    // Pilih barang dari modal
    function pilihBarang(id, nama, satuan, btn) {
        if (barangTerpilih.includes(id)) {
            toastr.warning('Barang ini sudah dipilih');
            return;
        }

        dtTerpilih.row.add([
            `${nama}<input type="hidden" name="barang_id[]" value="${id}">`,
            satuan,
            `<input type="number" name="jumlah[]" class="form-control" value="1" min="1">`,
            `<input type="text" name="harga[]" class="form-control harga" value="0" data-value="0">`,
            `<span class="subtotal">Rp 0</span>`,
            `<button type="button" class="btn btn-danger btn-sm" onclick="hapusBarang(${id}, this)">Hapus</button>`
        ]).draw(false);

        barangTerpilih.push(id);
        modalBarang.hide();
        updateSubtotal();
    }

    // Hapus barang
    function hapusBarang(id, btn) {
        let row = dtTerpilih.row($(btn).closest('tr'));

        function removeRow() {
            row.remove().draw(false);
            if (id) barangTerpilih = barangTerpilih.filter(item => item.toString() !== id.toString());
            updateSubtotal();
            ResultToast.fire({
                icon: 'success',
                title: 'Barang berhasil dihapus'
            });
        }

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Barang akan dihapus dari pembelian!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                removeRow();
                if (id && id > 0) {
                    $.post('<?= site_url("pembelian/hapus_barang") ?>/' + id, function (res) {
                        let response = JSON.parse(res);
                        if (response.status !== 'success') {
                            ResultToast.fire({
                                icon: 'error',
                                title: 'Gagal menghapus di database'
                            });
                        }
                    });
                }
            }
        });
    }

    // Update subtotal
    function updateSubtotal() {
        let totalSemua = 0;

        $('#tabel_barang_terpilih tbody tr').each(function () {
            let jumlah = parseFloat($(this).find('input[name="jumlah[]"]').val()) || 0;
            let harga = parseFloat($(this).find('input[name="harga[]"]').data('value')) || 0;

            let subtotal = jumlah * harga;
            $(this).find('.subtotal').text(formatRupiah(subtotal));
            totalSemua += subtotal;
        });

        $('#grandTotal').text(formatRupiah(totalSemua));
    }

    // Auto update subtotal saat jumlah/harga berubah
    $(document).on('input', 'input[name="jumlah[]"]', function () {
        updateSubtotal();
    });

    // Format Rupiah tanpa desimal untuk tampilan
    function formatRupiah(num) {
        if (isNaN(num)) num = 0;
        return 'Rp ' + Number(num).toLocaleString('id-ID'); // tampil tanpa desimal
    }

    $(document).on('input', '.harga', function () {
        let input = $(this);
        let value = input.val().replace(/[^0-9]/g, ''); // ambil angka saja
        let floatVal = parseFloat(value) || 0;

        input.data('value', floatVal); // simpan angka asli untuk subtotal/database

        // Format Rupiah otomatis
        if (value.length > 0) {
            let formatted = 'Rp ' + floatVal.toLocaleString('id-ID');
            input.val(formatted);
        } else {
            input.val('');
        }

        updateSubtotal(); // update subtotal realtime
    });

    $('form').on('submit', function () {
        $('.harga').each(function () {
            let valDecimal = parseFloat($(this).data('value')).toFixed(2);
            $(this).val(valDecimal);
        });
    });

</script>
<?= $this->endSection() ?>