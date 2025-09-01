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
    <!-- FilePond CSS & JS + plugin interaktif -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">
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
    <!-- loader END -->
    <!-- Sign in Start -->
    <section class="sign-in-page">
        <?= $this->renderSection('content') ?>
    </section>

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

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

    <!-- Appear JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/jquery.appear.js"></script>
    <!-- Countdown JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/countdown.min.js"></script>
    <!-- Counterup JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/jquery.counterup.min.js"></script>
    <!-- Wow JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/wow.min.js"></script>
    <!-- Apexcharts JavaScript -->
    <script src="<?= base_url('template/html/') ?>js/apexcharts.js"></script>
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

    <!-- Script Show/Hide Password -->

    <script>
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
    <?= $this->renderSection('scripts') ?>
    <script>
        $(window).on('load', function () {
            $('#loader').fadeOut('slow');
        });
    </script>
</body>

</html>