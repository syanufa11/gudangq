<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <!-- Menu toggle & Logo -->
            <div class="iq-menu-bt d-flex align-items-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
                    <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
                </div>
                <div class="iq-navbar-logo d-flex justify-content-between">
                    <a href="<?= base_url('/dashboard') ?>" class="header-logo">
                        <!-- Logo dari database -->
                        <img src="<?= isset($aplikasi['logo']) ? base_url($aplikasi['logo']) : base_url('template/html/images/logo.png') ?>"
                            class="img-fluid rounded-normal" alt="Logo">
                        <div class="logo-title">
                            <!-- Nama aplikasi dari database -->
                            <span class="text-danger text-uppercase font-weight-bold">
                                <?= isset($aplikasi['nama']) ? $aplikasi['nama'] : 'Server' ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Breadcrumb -->
            <div class="navbar-breadcrumb">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 text-dark"><?= $title ?></h4>
                        <?php if (service('uri')->getSegment(1) !== 'dashboard'): ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-white p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                                </ol>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Navbar toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                <i class="ri-menu-3-line"></i>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-list">
                    <!-- Notifications -->
                    
                </ul>
            </div>

            <!-- User menu -->
            <ul class="navbar-list">
                <li class="line-height">
                    <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                        <img src="<?= $user['foto'] ?>" class="img-fluid rounded-circle" alt="user">
                    </a>
                    <div class="iq-sub-dropdown iq-user-dropdown">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0">
                                <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">
                                        Hello, <?= $user['username'] ?? 'Guest' ?>
                                    </h5>
                                    <span class="text-white font-size-12"><?= $user['role_name'] ?></span>
                                </div>

                                <!-- Menu items -->
                                <a href="<?= base_url('profile') ?>" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-file-user-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0">Profile</h6>
                                            <p class="mb-0 font-size-12">View personal profile details</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="<?= base_url('profile/password') ?>" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-lock-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0">Ubah Password</h6>
                                            <p class="mb-0 font-size-12">Change your account password</p>
                                        </div>
                                    </div>
                                </a>

                                <div class="d-inline-block w-100 text-center p-3">
                                    <form action="<?= base_url('auth/logout') ?>" method="post" id="logoutForm">
                                        <button type="submit" class="bg-primary iq-sign-btn" id="btnLogout">
                                            Logout <i class="ri-login-box-line ml-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>


        </nav>
    </div>
</div>