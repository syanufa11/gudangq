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
                    <form action="<?= site_url('profile/update') ?>" method="POST" enctype="multipart/form-data"
                        id="profileForm">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <input type="text" class="form-control" name="name"
                                value="<?= isset($users) ? $users['name'] : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= isset($users) ? $users['email'] : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Profil</label>
                            <div class="upload-box" id="uploadBox" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
                                <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(event)"
                                    style="display: none;">
                                <div class="upload-content" id="uploadContent">
                                    <i class="las la-upload" style="font-size: 36px; color: #0d6efd;"></i>
                                    <p id="uploadText">
                                        <?= isset($users['foto']) && !empty($users['foto']) ? 'Klik atau seret foto untuk ganti' : 'Klik atau seret foto ke sini' ?>
                                    </p>
                                </div>
                                <img id="preview" src="<?= isset($users['foto']) ? base_url($users['foto']) : '#' ?>"
                                    style="display: <?= isset($users['foto']) ? 'block' : 'none' ?>;"
                                    class="img-thumbnail mt-3 mx-auto d-block">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('foto');
    const preview = document.getElementById('preview');
    const uploadText = document.getElementById('uploadText');

    // Klik untuk pilih file
    uploadBox.addEventListener('click', () => fileInput.click());

    // Drag & drop
    function handleDragOver(event) {
        event.preventDefault();
        uploadBox.style.background = '#e7f1ff';
    }
    function handleDragLeave(event) {
        event.preventDefault();
        uploadBox.style.background = '#f8f9fa';
    }
    function handleDrop(event) {
        event.preventDefault();
        uploadBox.style.background = '#f8f9fa';
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            previewImage({ target: fileInput });
        }
    }

    // Preview + validasi
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (!allowedTypes.includes(file.type)) {
                ResultToast.fire({ icon: 'error', title: 'Foto harus berupa PNG, JPG, atau JPEG!' });
                input.value = '';
                uploadText.textContent = 'Klik atau seret foto untuk ganti';
                return;
            }

            if (file.size > maxSize) {
                ResultToast.fire({ icon: 'error', title: 'Ukuran foto maksimal 2MB!' });
                input.value = '';
                uploadText.textContent = 'Klik atau seret foto untuk ganti';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                uploadText.textContent = file.name;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
<?= $this->endSection() ?>