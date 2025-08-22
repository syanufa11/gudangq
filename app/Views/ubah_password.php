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
                    <form action="<?= site_url('profile/password/update') ?>" method="POST" id="passwordForm">
                        <?= csrf_field() ?>

                        <!-- Password Lama -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Password Lama</label>
                            <div class="position-relative d-flex align-items-center">
                                <input type="password" class="form-control pe-5" name="current_password"
                                    id="current_password" placeholder="Masukkan password lama" required>
                                <i class="input-icon password-toggle fa fa-eye"
                                    onclick="togglePassword('current_password', this)" title="Show Password"
                                    style="position: absolute; right: 15px; cursor: pointer;"></i>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">Password Baru</label>
                            <div class="position-relative d-flex align-items-center">
                                <input type="password" class="form-control pe-5" name="new_password" id="new_password"
                                    placeholder="Masukkan password baru" required>
                                <i class="input-icon password-toggle fa fa-eye"
                                    onclick="togglePassword('new_password', this)" title="Show Password"
                                    style="position: absolute; right: 15px; cursor: pointer;"></i>
                            </div>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <div class="position-relative d-flex align-items-center">
                                <input type="password" class="form-control pe-5" name="confirm_password"
                                    id="confirm_password" placeholder="Konfirmasi password baru" required>
                                <i class="input-icon password-toggle fa fa-eye"
                                    onclick="togglePassword('confirm_password', this)" title="Show Password"
                                    style="position: absolute; right: 15px; cursor: pointer;"></i>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function togglePassword(fieldId, icon) {
        const input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            icon.title = "Hide Password";
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.title = "Show Password";
        }
    }
</script>
<?= $this->endSection() ?>