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
                        <table id="tabel_user" class="table table-bordered table-hover align-middle w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($users as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?>.</td>
                                        <td>
                                            <?php if (!empty($row['foto']) && file_exists($row['foto'])): ?>
                                                <img src="<?= base_url($row['foto']) ?>" alt="Foto"
                                                    style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                            <?php else: ?>
                                                <img src="<?= base_url('images/default-user.png') ?>" alt="Foto"
                                                    style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['username'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['role_name'] ?? '-' ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="openModal('<?= $row['id'] ?>','<?= $row['name'] ?>','<?= $row['username'] ?>','<?= $row['email'] ?>','<?= $row['role_id'] ?>','<?= !empty($row['foto']) ? base_url($row['foto']) : '' ?>')">
                                                <i class="las la-edit"></i> <span class="d-none d-sm-inline">Edit</span>
                                            </button>
                                            <button class="btn btn-danger"
                                                onclick="hapusData(<?= $row['id'] ?>, '<?= site_url('user/delete') ?>', 'User')">
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
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= site_url('user/store') ?>" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Form User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="mb-3">
                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="username">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3 position-relative">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Masukkan password">
                    <i class="input-icon password-toggle fa fa-eye" id="passwordToggle" onclick="togglePassword()"
                        title="Show Password"
                        style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
                </div>
                <div class="mb-3">
                    <label for="role_id">Role <span class="text-danger">*</span></label>
                    <select class="form-control" name="role_id" id="role_id" required>
                        <option value="" disabled selected>-- Pilih Role --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Upload Box -->
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <div class="upload-box" onclick="document.getElementById('foto').click()">
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(event)"
                            style="display: none;">
                        <div class="upload-content" id="uploadContent">
                            <i class="las la-upload" style="font-size: 36px; color: #0d6efd;"></i>
                            <p id="uploadText" style="color:#0d6efd;">Klik atau seret foto ke sini</p>
                        </div>
                        <img id="preview" src="#" style="display: none;" class="img-thumbnail mt-3 mx-auto d-block">
                    </div>
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
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('passwordToggle');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            icon.title = "Hide Password";
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.title = "Show Password";
        }
    }

    $(function () {
        $('#tabel_user').DataTable({
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

    let modal = new bootstrap.Modal(document.getElementById('userModal'));

    function openModal(id = '', name = '', username = '', email = '', role_id = '', foto = '') {
        $('#id').val(id);
        $('#name').val(name);
        $('#username').val(username);
        $('#email').val(email);
        $('#role_id').val(role_id);
        $('#password').val('');

        const preview = document.getElementById('preview');
        const uploadText = document.getElementById('uploadText');

        if (foto) {
            preview.src = foto;
            preview.style.display = 'block';
            uploadText.textContent = 'Foto saat ini';
        } else {
            preview.src = '#';
            preview.style.display = 'none';
            uploadText.textContent = 'Klik atau seret foto ke sini';
        }

        // Reset input file
        document.getElementById('foto').value = '';

        modal.show();
    }

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const text = document.getElementById('uploadText');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
            const maxSize = 2 * 1024 * 1024; // 2MB

            // Validasi tipe file
            if (!allowedTypes.includes(file.type)) {
                ResultToast.fire({
                    icon: 'error',
                    title: 'Foto harus berupa PNG, JPG, atau JPEG!'
                });
                input.value = '';
                preview.style.display = 'none';
                text.textContent = 'Klik atau seret foto ke sini';
                return;
            }

            // Validasi ukuran file
            if (file.size > maxSize) {
                ResultToast.fire({
                    icon: 'error',
                    title: 'Ukuran foto maksimal 2MB!'
                });
                input.value = '';
                preview.style.display = 'none';
                text.textContent = 'Klik atau seret foto ke sini';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                text.textContent = file.name;
            }
            reader.readAsDataURL(file);
        }
    }

</script>
<?= $this->endSection() ?>