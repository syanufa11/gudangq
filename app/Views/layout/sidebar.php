<?php $uri = service('uri'); ?>

<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
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
        <div class="iq-menu-bt-sidebar">
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
                    <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <?php $uri = service('uri'); ?>

                <li class="<?= ($uri->getSegment(1) == 'dashboard') ? 'active active-menu' : '' ?>">
                    <a href="<?= base_url('/dashboard') ?>"><i class="las la-home"></i>Dashboard</a>
                </li>
                <li class="<?= ($uri->getSegment(1) == 'kategori') ? 'active' : '' ?>">
                    <a href="<?= base_url('/kategori') ?>" class="iq-waves-effect"><i
                            class="las la-list"></i><span>Kategori</span></a>
                </li>
                <li class="<?= ($uri->getSegment(1) == 'barang') ? 'active' : '' ?>">
                    <a href="<?= base_url('/barang') ?>" class="iq-waves-effect"><i
                            class="las la-box"></i><span>Barang</span></a>
                </li>
                <li class="<?= ($uri->getSegment(1) == 'pembelian') ? 'active' : '' ?>">
                    <a href="<?= base_url('/pembelian') ?>" class="iq-waves-effect"><i
                            class="las la-shopping-cart"></i><span>Pembelian</span></a>
                </li>

                <li class="<?= ($uri->getSegment(1) == 'transaksi') ? 'active' : '' ?>">
                    <a href="#transaksi" class="iq-waves-effect" data-toggle="collapse"
                        aria-expanded="<?= ($uri->getSegment(1) == 'transaksi') ? 'true' : 'false' ?>">
                        <i class="las la-exchange-alt"></i><span>Transaksi</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="transaksi"
                        class="iq-submenu collapse <?= ($uri->getSegment(1) == 'transaksi') ? 'show' : '' ?>"
                        data-parent="#iq-sidebar-toggle">
                        <li class="<?= ($uri->getSegment(2) == 'masuk') ? 'active' : '' ?>"><a
                                href="<?= base_url('/transaksi/masuk') ?>"><i class="las la-arrow-down"></i>Barang
                                Masuk</a></li>
                        <li class="<?= ($uri->getSegment(2) == 'keluar') ? 'active' : '' ?>"><a
                                href="<?= base_url('/transaksi/keluar') ?>"><i class="las la-arrow-up"></i>Barang
                                Keluar</a></li>
                    </ul>
                </li>

                <li class="<?= ($uri->getSegment(1) == 'laporan') ? 'active' : '' ?>">
                    <a href="#laporan" class="iq-waves-effect" data-toggle="collapse"
                        aria-expanded="<?= ($uri->getSegment(1) == 'laporan') ? 'true' : 'false' ?>">
                        <i class="las la-file-alt"></i><span>Laporan</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="laporan" class="iq-submenu collapse <?= ($uri->getSegment(1) == 'laporan') ? 'show' : '' ?>"
                        data-parent="#iq-sidebar-toggle">
                        <li class="<?= ($uri->getSegment(2) == 'masuk') ? 'active' : '' ?>"><a
                                href="<?= base_url('/laporan/masuk') ?>"><i class="las la-arrow-down"></i>Barang
                                Masuk</a></li>
                        <li class="<?= ($uri->getSegment(2) == 'keluar') ? 'active' : '' ?>"><a
                                href="<?= base_url('/laporan/keluar') ?>"><i class="las la-arrow-up"></i>Barang
                                Keluar</a></li>
                    </ul>
                </li>
                <?php
                $segment1 = $uri->getSegment(1); // ambil segment pertama
                
                $pengaturanSubmenu = ['aplikasi', 'role', 'user']; // daftar submenu pengaturan
                ?>

                <li class="<?= in_array($segment1, $pengaturanSubmenu) ? 'active' : '' ?>">
                    <a href="#pengaturan" class="iq-waves-effect" data-toggle="collapse"
                        aria-expanded="<?= in_array($segment1, $pengaturanSubmenu) ? 'true' : 'false' ?>">
                        <i class="las la-cog"></i><span>Pengaturan</span>
                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="pengaturan"
                        class="iq-submenu collapse <?= in_array($segment1, $pengaturanSubmenu) ? 'show' : '' ?>"
                        data-parent="#iq-sidebar-toggle">
                        <li class="<?= ($segment1 == 'aplikasi') ? 'active' : '' ?>">
                            <a href="<?= base_url('/aplikasi') ?>"><i class="las la-tools"></i> Aplikasi</a>
                        </li>
                        <li class="<?= ($segment1 == 'role') ? 'active' : '' ?>">
                            <a href="<?= base_url('/role') ?>"><i class="las la-user-shield"></i> Role User</a>
                        </li>
                        <li class="<?= ($segment1 == 'user') ? 'active' : '' ?>">
                            <a href="<?= base_url('/user') ?>"><i class="las la-user"></i> User</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>