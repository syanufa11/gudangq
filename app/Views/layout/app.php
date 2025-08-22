<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= isset($aplikasi['nama']) ? $aplikasi['nama'] : 'Server' ?> | <?= $title; ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon"
        href="<?= isset($aplikasi['logo']) ? base_url($aplikasi['logo']) : base_url('template/html/images/logo.png') ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('template/html/') ?>css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= base_url('template/html/') ?>css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?= base_url('template/html/') ?>css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?= base_url('template/html/') ?>css/responsive.css">

    <!-- DataTables Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

    <!-- Select2 Bootstrap 4 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />


    <style>
        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .input-icon:hover {
            color: var(--primary-color);
        }

        .password-toggle {
            cursor: pointer;
            user-select: none;
        }

        .password-toggle:hover {
            color: var(--primary-color);
            transform: translateY(-50%) scale(1.1);
        }
    </style>

    <style>
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .bg-primary-light {
            background-color: rgba(0, 123, 255, 0.1) !important;
        }

        .bg-success-light {
            background-color: rgba(40, 167, 69, 0.1) !important;
        }

        .bg-info-light {
            background-color: rgba(23, 162, 184, 0.1) !important;
        }

        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-secondary-light {
            background-color: rgba(108, 117, 125, 0.1) !important;
        }

        .card {
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }


        .badge {
            font-size: 0.875em;
        }

        .h-100 {
            height: 100% !important;
        }

        /* Bootstrap 4 compatibility fixes */
        .border-0 {
            border: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-md-right {
            text-align: right !important;
        }

        @media (max-width: 767.98px) {
            .text-md-right {
                text-align: left !important;
            }
        }

        .thead-light th {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
    </style>
    <style>
        body {
            background-color: #f8f9fe;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            transition: all 0.3s ease;
            border: none !important;
            border-radius: 15px !important;
        }

        .card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-2px);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05) !important;
        }

        .btn {
            transition: all 0.3s ease;
            border-radius: 8px !important;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .badge {
            font-weight: 500;
        }

        .gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px !important;
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .icon-bg {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .border-left-primary {
            border-left: 4px solid #007bff !important;
        }

        .border-left-success {
            border-left: 4px solid #28a745 !important;
        }

        .border-left-warning {
            border-left: 4px solid #ffc107 !important;
        }

        .border-left-danger {
            border-left: 4px solid #dc3545 !important;
        }

        .border-left-info {
            border-left: 4px solid #17a2b8 !important;
        }

        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .dropdown-item {
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 123, 255, 0.1);
            transform: translateX(5px);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Real-time data indicator */
        .live-indicator::before {
            content: '';
            position: absolute;
            top: -5px;
            right: -5px;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0.3;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .bg-light-primary {
            background-color: rgba(0, 123, 255, 0.1) !important;
        }

        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1) !important;
        }

        .bg-light-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-light-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .bg-light-info {
            background-color: rgba(23, 162, 184, 0.1) !important;
        }

        .text-primary {
            color: #007bff !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-info {
            color: #17a2b8 !important;
        }

        .rounded-pill {
            border-radius: 50rem !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .font-weight-semibold {
            font-weight: 600 !important;
        }

        .small {
            font-size: 0.875rem;
        }

        .btn-group-custom a:not(:last-child) {
            margin-right: 0.5rem;
            /* jarak antar tombol */
        }
    </style>
    <style>
        .upload-box {
            border: 2px dashed #0d6efd;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            position: relative;
            transition: background 0.3s, border-color 0.3s;
            background: #f8f9fa;
        }

        .upload-box:hover {
            background: #e7f1ff;
            border-color: #0a58ca;
        }

        .upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .upload-box img {
            max-width: 150px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .upload-content p {
            margin: 0;
            font-weight: 500;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Fullscreen overlay dengan gradient ungu animasi */
        #loader {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 400% 400%;
            animation: gradientAnimation 8s ease infinite;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Progress bar container */
        .loader-bar-container {
            width: 250px;
            height: 10px;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px #00000055;
            margin-bottom: 1rem;
        }

        /* Animated progress bar */
        .loader-bar {
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, #ba68c8, #ce93d8);
            border-radius: 5px;
            box-shadow: 0 0 10px #ba68c888;
            animation: loading 2s ease-in-out infinite;
        }

        @keyframes loading {
            0% {
                width: 0;
            }

            50% {
                width: 80%;
            }

            100% {
                width: 100%;
            }
        }

        /* Loader text */
        .loader-text {
            color: #e1bee7;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            text-align: center;
        }
    </style>

</head>

<body>
    <!-- Loader Fullscreen Modern -->
    <div id="loader">
        <div class="loader-bar-container">
            <div class="loader-bar"></div>
        </div>
        <p class="loader-text">Memuat halaman...</p>
    </div>

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Sidebar  -->
        <?= $this->include('layout/sidebar') ?>
        <!-- TOP Nav Bar -->
        <?= $this->include('layout/topbar') ?>
        <!-- TOP Nav Bar END -->
        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <!-- Wrapper END -->
    <!-- Footer -->
    <footer class="iq-footer text-center">
        &copy; <?= date('Y') ?> <?= isset($aplikasi['nama']) ? $aplikasi['nama'] : 'Server' ?>. All Rights Reserved.
    </footer>


    <!-- Footer END -->
    <!-- color-customizer -->

    <!-- color-customizer END -->
    <!-- Optional JavaScript -->
    <!-- jQuery dulu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="<?= base_url('template/html/') ?>js/popper.min.js"></script>
    <!-- Bootstrap 4 JS -->
    <script src="<?= base_url('template/html/') ?>js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 4 JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <!-- Appear JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/jquery.appear.js"></script>
    <!-- Countdown JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/countdown.min.js"></script>
    <!-- Counterup JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/jquery.counterup.min.js"></script>
    <!-- Wow JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/wow.min.js"></script>
    <!-- Apexcharts JavaScript -->
    <!-- Slick JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/slick.min.js"></script>
    <!-- Owl Carousel JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/owl.carousel.min.js"></script>
    <!-- Magnific Popup JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/jquery.magnific-popup.min.js"></script>
    <!-- Smooth Scrollbar JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/smooth-scrollbar.js"></script>
    <!-- lottie JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/lottie.js"></script>
    <!-- am core JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/core.js"></script>
    <!-- am charts JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/charts.js"></script>
    <!-- am animated JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/animated.js"></script>
    <!-- am kelly JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/kelly.js"></script>
    <!-- am maps JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/maps.js"></script>
    <!-- am worldLow JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/worldLow.js"></script>
    <!-- Raphael-min JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/raphael-min.js"></script>
    <!-- Morris JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/morris.js"></script>
    <!-- Morris min JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/morris.min.js"></script>
    <!-- Flatpicker Js -->
    <script src="<?= base_url('template/html/') ?>js/flatpickr.js"></script>
    <!-- Style Customizer -->
    <script src="<?= base_url('template/html/') ?>js/style-customizer.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/chart-custom.js"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/custom.js"></script>



    <script>
        // Toast konfirmasi hapus
        function hapusData(id, url, namaEntitas = 'data') {
            Swal.fire({
                title: `Hapus ${namaEntitas}?`,
                text: "Tindakan ini tidak bisa dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `${url}/${id}`;
                }
            });
        }

        // Toast notifikasi hasil
        const ResultToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 2000,
            timerProgressBar: true,
            customClass: {
                popup: 'auto-width-toast'
            },
            padding: '1rem'
        });

        <?php if (session()->getFlashdata('success')): ?>
            ResultToast.fire({
                icon: 'success',
                title: "<?= session()->getFlashdata('success'); ?>"
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            ResultToast.fire({
                icon: 'error',
                title: "<?= session()->getFlashdata('error'); ?>"
            });
        <?php endif; ?>
    </script>

    <style>
        /* Lebar otomatis menyesuaikan teks, max 400px */
        .auto-width-toast {
            width: auto !important;
            max-width: 400px !important;
            min-width: 250px;
            /* tetap ada lebar minimum */
        }
    </style>

    <script>
        document.getElementById('btnLogout')?.addEventListener('click', function (e) {
            e.preventDefault(); // hentikan default submit

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan logout dari sistem",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form logout
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>

    <!-- this-?renderSection(?scripts?)-->
    <?= $this->renderSection('scripts') ?>
    <script>
        $(window).on('load', function () {
            $('#loader').fadeOut('slow');
        });
    </script>

</body>

</html>