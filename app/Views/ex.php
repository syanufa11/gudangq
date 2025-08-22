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
                    <a href="<?= base_url('pembelian/create') ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
                <div class="iq-card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables -->
<script>
    $(document).ready(function () {
        $('#pembelianTable').DataTable({
            "paging": true,
            "pageLength": 5,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "dom": '<"top">rt<"bottom"p>',
            "language": {
                "paginate": {
                    "previous": "&laquo;",
                    "next": "&raquo;"
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
