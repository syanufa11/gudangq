<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>


<div class="container-fluid px-4 py-4">
    <!-- Header Welcome with Gradient -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg gradient-header animate-card">
                <div class="card-body text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2 font-weight-bold" style="color: #FFD700;">
                                Selamat datang kembali, <?= session()->get('username') ?? 'User' ?>! 👋
                            </h2>

                            <p class="mb-1" style="opacity: 0.9;">
                                Kelola inventori Anda dengan mudah dan efisien
                            </p>
                            <div class="d-flex align-items-center mt-3">
                                <i class="fas fa-boxes mr-2"></i>
                                <span class="h5 mb-0">
                                    Total Stok: <strong><?= number_format($totalBarang) ?> unit</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2) !important;">
                                <i class="fas fa-chart-line fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Stat Cards -->
    <div class="row mb-4">
        <!-- Total Kategori -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card animate-card border-left-info">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">TOTAL KATEGORI</p>
                            <h3 class="mb-0 font-weight-bold text-dark"><?= $totalKategori ?></h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> Aktif</small>
                        </div>
                        <div class="icon-bg bg-light-info">
                            <i class="fas fa-tags fa-lg text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Barang -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card animate-card border-left-success"
                style="animation-delay: 0.1s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">TOTAL BARANG</p>
                            <h3 class="mb-0 font-weight-bold text-dark"><?= number_format($totalBarang) ?></h3>
                            <small class="text-success"><i class="fas fa-check-circle"></i> Tersedia</small>
                        </div>
                        <div class="icon-bg bg-light-success">
                            <i class="fas fa-cube fa-lg text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Masuk -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card animate-card border-left-warning"
                style="animation-delay: 0.2s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">BARANG MASUK</p>
                            <h3 class="mb-0 font-weight-bold text-dark"><?= number_format($totalBarangMasuk) ?></h3>
                            <small class="text-warning">Hari ini: <strong><?= $barangMasukHariIni ?></strong></small>
                        </div>
                        <div class="icon-bg bg-light-warning">
                            <i class="fas fa-arrow-down fa-lg text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Keluar -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card animate-card border-left-danger"
                style="animation-delay: 0.3s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">BARANG KELUAR</p>
                            <h3 class="mb-0 font-weight-bold text-dark"><?= number_format($totalBarangKeluar) ?></h3>
                            <small class="text-danger">Hari ini: <strong><?= $barangKeluarHariIni ?></strong></small>
                        </div>
                        <div class="icon-bg bg-light-danger">
                            <i class="fas fa-arrow-up fa-lg text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm animate-card" style="animation-delay: 0.4s;">
                <div class="card-body p-4">
                    <h6 class="card-title font-weight-bold mb-3">
                        <i class="fas fa-bolt text-primary mr-2"></i>Aksi Cepat
                    </h6>
                    <div class="row">
                        <!-- Barang Masuk -->
                        <div class="col-md-3 col-6 mb-2">
                            <a href="<?= base_url('/transaksi/masuk') ?>" class="btn btn-success btn-sm btn-block py-2">
                                <i class="fas fa-download mr-1"></i> Barang Masuk
                            </a>
                        </div>

                        <!-- Barang Keluar -->
                        <div class="col-md-3 col-6 mb-2">
                            <a href="<?= base_url('/transaksi/keluar') ?>"
                                class="btn btn-warning btn-sm btn-block py-2">
                                <i class="fas fa-upload mr-1"></i> Barang Keluar
                            </a>
                        </div>

                        <!-- Laporan Masuk -->
                        <div class="col-md-3 col-6 mb-2">
                            <a href="<?= base_url('/laporan/masuk') ?>" class="btn btn-primary btn-sm btn-block py-2">
                                <i class="fas fa-chart-bar mr-1"></i> Laporan Masuk
                            </a>
                        </div>

                        <!-- Laporan Keluar -->
                        <div class="col-md-3 col-6 mb-2">
                            <a href="<?= base_url('/laporan/keluar') ?>" class="btn btn-danger btn-sm btn-block py-2">
                                <i class="fas fa-chart-bar mr-1"></i> Laporan Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Charts -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-3">
            <div class="card border-0 shadow-sm h-100 animate-card chart-container" style="animation-delay: 0.5s;">
                <div class="card-header bg-transparent border-0 p-4 pb-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 font-weight-bold">
                            <i class="fas fa-chart-area text-primary mr-2"></i>Tren Barang Masuk vs Keluar
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="chartDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                6 Bulan Terakhir
                            </button>
                            <div class="dropdown-menu" aria-labelledby="chartDropdown">
                                <a class="dropdown-item" href="#" onclick="updateChart('3months')">3 Bulan</a>
                                <a class="dropdown-item" href="#" onclick="updateChart('6months')">6 Bulan</a>
                                <a class="dropdown-item" href="#" onclick="updateChart('1year')">1 Tahun</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 pt-2">
                    <div id="chart-masuk-keluar"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100 animate-card chart-container" style="animation-delay: 0.6s;">
                <div class="card-header bg-transparent border-0 p-4 pb-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-chart-pie text-success mr-2"></i>Distribusi Stok Kategori
                    </h6>
                </div>
                <div class="card-body p-4 pt-2">
                    <div id="chart-stok-kategori"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm animate-card" style="animation-delay: 0.7s;">
                <div class="card-header bg-transparent border-0 p-4 pb-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 font-weight-bold">
                            <i class="fas fa-history text-info mr-2"></i>Pembelian Terbaru
                        </h6>
                        <a href="<?= base_url('pembelian') ?>" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-4 pt-2">
                    <!-- Search & Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control border-left-0"
                                    placeholder="Cari barang, vendor, atau kategori..." id="searchInput">
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-outline-primary mr-2" data-toggle="modal" data-target="#filterModal">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <a href="<?= base_url('pembelian/export') ?>?kategori=" id="exportBtn"
                                class="btn btn-primary">
                                <i class="fas fa-download mr-1"></i> Export
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="pembelianTable">
                            <thead class="thead-light">
                                <tr>
                                    <th><i class="fas fa-calendar mr-1"></i>Tanggal</th>
                                    <th><i class="fas fa-store mr-1"></i>Vendor</th>
                                    <th><i class="fas fa-box mr-1"></i>Barang</th>
                                    <th class="d-none">Kategori</th> <!-- hidden column -->
                                    <th class="text-right"><i class="fas fa-hashtag mr-1"></i>Jumlah</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembelianTerbaru as $pembelian): ?>
                                    <?php
                                    $allBarang = array_map(function ($b) {
                                        return $b['nama_barang'];
                                    }, $pembelian['barang']);
                                    $allKategori = array_map(function ($b) {
                                        return $b['kategori'];
                                    }, $pembelian['barang']);
                                    ?>
                                    <tr
                                        data-detail='<?= htmlspecialchars(json_encode($pembelian['barang']), ENT_QUOTES, 'UTF-8') ?>'>
                                        <td><?= tgl_indo($pembelian['tanggal_pembelian']) ?></td>
                                        <td><?= esc($pembelian['nama_vendor']) ?></td>
                                        <td class="icon-toggle">
                                            <i class="fas fa-plus-circle text-primary"></i> Klik untuk lihat barang
                                        </td>
                                        <td class="d-none"><?= implode(', ', $allKategori) ?>
                                            <?= implode(', ', $allBarang) ?>
                                        </td>
                                        <td class="text-right">
                                            <?= number_format(array_sum(array_column($pembelian['barang'], 'jumlah'))) ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" type="button" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('pembelian/detail/' . $pembelian['id']) ?>">
                                                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('pembelian/edit/' . $pembelian['id']) ?>">
                                                        <i class="fas fa-edit mr-2"></i>Edit
                                                    </a>
                                                    <button class="dropdown-item"
                                                        onclick="hapusData(<?= $pembelian['id'] ?>, '<?= site_url('pembelian/delete') ?>', 'Pembelian')">
                                                        <i class="fas fa-trash mr-2"></i>Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>




                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="filterKategori">Kategori</label>
                    <select id="filterKategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($kategoriList as $kategori): ?>
                            <option value="<?= esc($kategori) ?>"><?= esc($kategori) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="applyFilter">Terapkan</button>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- Toast Container -->
<div class="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 1055;"></div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function () {
        // Data dari controller
        const allBulan = <?= json_encode($masukKeluarPerBulan['bulan']) ?>;
        const allMasuk = <?= json_encode($masukKeluarPerBulan['masuk']) ?>;
        const allKeluar = <?= json_encode($masukKeluarPerBulan['keluar']) ?>;

        function getLastN(arr, n) {
            return arr.slice(-n);
        }

        const chartData = {
            '3months': {
                categories: getLastN(allBulan, 3),
                masuk: getLastN(allMasuk, 3),
                keluar: getLastN(allKeluar, 3)
            },
            '6months': {
                categories: getLastN(allBulan, 6),
                masuk: getLastN(allMasuk, 6),
                keluar: getLastN(allKeluar, 6)
            },
            '1year': {
                categories: allBulan,
                masuk: allMasuk,
                keluar: allKeluar
            }
        };

        let currentChart = new ApexCharts(document.querySelector("#chart-masuk-keluar"), {
            chart: { type: 'area', height: 320, toolbar: { show: false } },
            series: [
                { name: 'Barang Masuk', data: chartData['6months'].masuk, color: '#28a745' },
                { name: 'Barang Keluar', data: chartData['6months'].keluar, color: '#dc3545' }
            ],
            xaxis: { categories: chartData['6months'].categories },
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.7, opacityTo: 0.1 } },
            tooltip: { y: { formatter: val => val.toLocaleString() + ' unit' } },
            legend: { position: 'top', horizontalAlign: 'right' }
        });

        currentChart.render();

        window.updateChart = function (period) {
            $('#chartDropdown').text({
                '3months': '3 Bulan Terakhir',
                '6months': '6 Bulan Terakhir',
                '1year': '1 Tahun Terakhir'
            }[period]);

            const data = chartData[period];
            currentChart.updateOptions({
                xaxis: { categories: data.categories },
                series: [
                    { name: 'Barang Masuk', data: data.masuk },
                    { name: 'Barang Keluar', data: data.keluar }
                ]
            });
        };
    });
</script>
<script>
    $(document).ready(function () {
        // Data stok kategori dari controller
        const stokKategori = <?= json_encode($stokPerKategori) ?>;

        const options = {
            chart: { type: 'donut', height: 300, fontFamily: 'Segoe UI, sans-serif' },
            series: stokKategori.map(k => parseInt(k.total_stok)), // total stok tiap kategori
            labels: stokKategori.map(k => k.nama),                // nama kategori
            colors: ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#00f2fe', '#ffb400', '#ff4b2b'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Stok',
                                formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString()
                            }
                        }
                    }
                }
            },
            legend: { position: 'bottom' },
            tooltip: { y: { formatter: val => val.toLocaleString() + ' unit' } }
        };

        new ApexCharts(document.querySelector("#chart-stok-kategori"), options).render();
    });
</script>

<script>
    $(document).ready(function () {
        var selectedKategori = "";

        var table = $('#pembelianTable').DataTable({
            paging: true,
            pageLength: 5,
            lengthChange: false,
            searching: true, // harus tetap true biar table.search() bisa dipakai
            ordering: true,
            info: false,
            columnDefs: [
                { targets: [3], visible: false } // kolom barang+kategori hidden
            ],
            language: {
                paginate: {
                    previous: "&laquo;",
                    next: "&raquo;"
                },
                emptyTable: "Belum ada data pembelian"
            },
            dom: '<"top">rt<"bottom"p><"clear">' // 🔥 hilangkan search bawaan DataTables
        });

        // 🔍 Search pakai input custom
        $('#searchInput').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Expand / Collapse list barang
        $('#pembelianTable tbody').on('click', 'td.icon-toggle i', function (e) {
            e.stopPropagation();
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                $(this).removeClass('fa-minus-circle text-danger').addClass('fa-plus-circle text-primary');
            } else {
                var detail = tr.data('detail');
                if (typeof detail === "string") {
                    detail = JSON.parse(detail);
                }

                var html = '<ul style="padding-left:15px; margin:0;">';
                detail.forEach(function (item) {
                    html += '<li><span class="badge badge-light">' + item.nama_barang + '</span> - ' +
                        item.jumlah + ' ' + item.satuan + ' - <span class="badge badge-dark">' + item.kategori + '</span></li>';
                });
                html += '</ul>';

                row.child(html).show();
                $(this).removeClass('fa-plus-circle text-primary').addClass('fa-minus-circle text-danger');
            }
        });

        // Custom filter kategori
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (!selectedKategori) return true;

            var kategoriCell = data[3] || "";
            return kategoriCell.toLowerCase().includes(selectedKategori.toLowerCase());
        });

        // Apply filter kategori
        $('#applyFilter').on('click', function () {
            selectedKategori = $('#filterKategori').val();

            table.draw();

            // update export link
            var exportUrl = "<?= base_url('pembelian/export') ?>?kategori=" + encodeURIComponent(selectedKategori);
            $('#exportBtn').attr('href', exportUrl);

            $('#filterModal').modal('hide');
        });
    });
</script>

<?= $this->endSection() ?>