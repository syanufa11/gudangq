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
                    <form action="<?= site_url('aplikasi/save') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Aplikasi</label>
                            <input type="text" class="form-control" name="nama"
                                value="<?= isset($aplikasi) ? $aplikasi['nama'] : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label fw-bold">Logo</label>
                            <?php if(isset($aplikasi['logo']) && !empty($aplikasi['logo'])): ?>
                                <div class="mb-2">
                                    <img src="<?= base_url($aplikasi['logo']) ?>" alt="Logo" style="max-height:100px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary"><i class="las la-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
