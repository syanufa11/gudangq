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
                        <table id="tabel_role" class="table table-bordered table-hover align-middle w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($roles as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?>.</td>
                                        <td><?= $row['name'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="openModal('<?= $row['id'] ?>','<?= $row['name'] ?>')">
                                                <i class="las la-edit"></i> <span class="d-none d-sm-inline">Edit</span>
                                            </button>
                                            <button class="btn btn-danger"
                                                onclick="hapusData(<?= $row['id'] ?>, '<?= site_url('role/delete') ?>', 'Role')">
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
<div class="modal fade" id="roleModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= site_url('role/store') ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="mb-3">
                    <label for="name">Nama Role <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" required>
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
        $('#tabel_role').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(difilter dari _MAX_ total entri)",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data tersedia",
                paginate: { first: "Pertama", previous: "Sebelumnya", next: "Berikutnya", last: "Terakhir" }
            },
        });
    });

    let modal = new bootstrap.Modal(document.getElementById('roleModal'));

    function openModal(id = '', name = '') {
        $('#id').val(id);
        $('#name').val(name);
        modal.show();
    }
</script>
<?= $this->endSection() ?>