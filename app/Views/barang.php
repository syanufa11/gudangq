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
                    <button class="btn btn-sm btn-primary" onclick="openModal()">
                        <i class="las la-plus"></i> Tambah
                    </button>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="tabel_barang" class="table table-bordered table-hover align-middle w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Barang</th>
                                    <th>Kode Barang</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($barang as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?>.</td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['kode_barang'] ?></td>
                                        <td><?= $row['kategori_nama'] ?></td>
                                        <td><?= $row['satuan'] ?></td>
                                        <td><?= $row['jumlah_stok'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" onclick="openModal(
                                                    '<?= $row['id'] ?>',
                                                    '<?= $row['nama_barang'] ?>',
                                                    '<?= $row['kode_barang'] ?>',
                                                    '<?= $row['kategori_id'] ?>',
                                                    '<?= $row['satuan'] ?>',
                                                    '<?= $row['jumlah_stok'] ?>'
                                                )">
                                                <i class="las la-edit"></i> <span class="d-none d-sm-inline">Edit</span>
                                            </button>
                                            <button class="btn btn-danger"
                                                onclick="hapusData(<?= $row['id'] ?>, '<?= site_url('barang/delete') ?>', 'Barang')">
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

<!-- Modal Form -->
<div class="modal fade" id="barangModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= site_url('barang/store') ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="mb-3">
                    <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_barang" id="nama_barang" required>
                </div>
                <div class="mb-3">
                    <label for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="kode_barang" id="kode_barang" readonly required>
                </div>
                <div class="mb-3">
                    <label for="kategori_id">Kategori <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="kategori_id" id="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="satuan">Satuan <span class="text-danger">*</span></label>
                    <select class="form-control select2-tags" name="satuan" id="satuan" required>
                        <option value="">-- Pilih atau tulis satuan --</option>
                        <option value="pcs">Pcs</option>
                        <option value="unit">Unit</option>
                        <option value="set">Set</option>
                        <option value="kg">Kg</option>
                    </select>
                    <small class="form-text text-muted">Jika satuan tidak ada di pilihan, bisa langsung ditulis
                        sendiri.</small>
                </div>
                <div class="mb-3">
                    <label for="jumlah_stok">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="jumlah_stok" id="jumlah_stok" min="1" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="las la-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="las la-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        // Inisialisasi DataTable
        $('#tabel_barang').DataTable({
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

        // Inisialisasi select2 untuk kategori
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: '-- Pilih Kategori --',
            allowClear: true,
            dropdownParent: $('#barangModal')
        });

        // Inisialisasi select2-tags untuk satuan
        $('.select2-tags').select2({
            theme: 'bootstrap4',
            width: '100%',
            tags: true,
            placeholder: '-- Pilih / Ketik Satuan --',
            allowClear: true,
            dropdownParent: $('#barangModal')
        }).on('select2:select', function (e) {
            let data = e.params.data;
            let exists = false;

            // Cek apakah sudah ada option dengan value sama (case-insensitive)
            $(this).find('option').each(function () {
                if ($(this).val().toLowerCase() === data.id.toLowerCase()) {
                    exists = true;
                    return false; // stop loop
                }
            });

            // Kalau belum ada, tambahkan
            if (!exists) {
                let newOption = new Option(data.text, data.id, false, true);
                $(this).append(newOption).trigger('change');
            }
        });

        $('form').on('submit', function (e) {
            let stok = parseInt($('#jumlah_stok').val());
            if (stok < 1 || isNaN(stok)) {
                e.preventDefault(); // hentikan submit
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Jumlah stok tidak boleh kurang dari 1!'
                });
                $('#jumlah_stok').focus();
                return false;
            }
        });

    });

    let modal = new bootstrap.Modal(document.getElementById('barangModal'));

    function openModal(id = '', nama_barang = '', kode_barang = '', kategori_id = '', satuan = '', jumlah_stok = '') {
        $('#id').val(id);
        $('#nama_barang').val(nama_barang);
        $('#jumlah_stok').val(jumlah_stok);
        $('#kategori_id').val(kategori_id).trigger('change');

        // Set satuan, dan tambahkan ke option kalau belum ada
        if (satuan) {
            let select = $('#satuan');
            let exists = false;
            select.find('option').each(function () {
                if ($(this).val().toLowerCase() === satuan.toLowerCase()) {
                    exists = true;
                    return false;
                }
            });
            if (!exists) {
                let newOption = new Option(satuan, satuan, false, true);
                select.append(newOption);
            }
            select.val(satuan).trigger('change');
        } else {
            $('#satuan').val(null).trigger('change'); // kosongkan saat tambah baru
        }

        if (id) {
            // Edit
            $('#kode_barang').val(kode_barang);
        } else {
            // Tambah baru, ambil kode dari server
            $.get('<?= site_url('barang/generate_kode') ?>', function (data) {
                $('#kode_barang').val(data);
            });
        }

        modal.show();
    }
</script>
<?= $this->endSection() ?>