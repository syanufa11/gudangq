<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default ke login (harus login dulu untuk akses dashboard)
$routes->get('/', 'Auth::index');

// Auth (login & logout) tetap bisa diakses publik
$routes->group('auth', function ($routes) {
    $routes->get('/', 'Auth::index');        // halaman login
    $routes->post('login', 'Auth::login');  // proses login
    $routes->post('logout', 'Auth::logout'); // proses logout
});

// Semua route lainnya wajib login
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');

    // Profile
    $routes->group('profile', function ($routes) {
        $routes->get('/', 'ProfileController::index');
        $routes->post('update', 'ProfileController::update');
        $routes->get('password', 'ProfileController::password');
        $routes->post('password/update', 'ProfileController::updatePassword');
    });

    // Kategori
    $routes->group('kategori', function ($routes) {
        $routes->get('/', 'KategoriController::index');
        $routes->post('store', 'KategoriController::store');
        $routes->get('delete/(:num)', 'KategoriController::delete/$1');
    });

    // Barang
    $routes->group('barang', function ($routes) {
        $routes->get('/', 'BarangController::index');
        $routes->get('generate_kode', 'BarangController::generateKode');
        $routes->post('store', 'BarangController::store');
        $routes->get('delete/(:num)', 'BarangController::delete/$1');
    });

    // Pembelian
    $routes->group('pembelian', function ($routes) {
        $routes->get('/', 'PembelianController::index');
        $routes->get('create', 'PembelianController::create');
        $routes->get('edit/(:num)', 'PembelianController::edit/$1');
        $routes->post('store', 'PembelianController::store');
        $routes->post('update/(:num)', 'PembelianController::update/$1');
        $routes->get('delete/(:num)', 'PembelianController::delete/$1');
        $routes->post('hapus_barang/(:num)', 'PembelianController::hapus_barang/$1');
        $routes->get('detail/(:num)', 'PembelianController::detail/$1');
        $routes->get('cetak_pdf/(:num)', 'PembelianController::cetak_pdf/$1');
        $routes->get('export', 'PembelianController::export');
    });

    // Transaksi
    $routes->group('transaksi', function ($routes) {
        $routes->get('masuk', 'Transaksi\BarangMasuk::index');
        $routes->get('masuk/detail/(:num)', 'Transaksi\BarangMasuk::detail/$1');
        $routes->get('masuk/cetak_pdf/(:num)', 'Transaksi\BarangMasuk::cetak_pdf/$1');

        $routes->get('keluar', 'Transaksi\BarangKeluar::index');
        $routes->get('keluar/create', 'Transaksi\BarangKeluar::create');
        $routes->post('keluar/store', 'Transaksi\BarangKeluar::store');
        $routes->get('keluar/edit/(:num)', 'Transaksi\BarangKeluar::edit/$1');
        $routes->post('keluar/update/(:num)', 'Transaksi\BarangKeluar::update/$1');
        $routes->get('keluar/delete/(:num)', 'Transaksi\BarangKeluar::delete/$1');
        $routes->get('keluar/detail/(:num)', 'Transaksi\BarangKeluar::detail/$1');
        $routes->get('keluar/cetak_pdf/(:num)', 'Transaksi\BarangKeluar::cetak_pdf/$1');
    });

    // Aplikasi
    $routes->group('aplikasi', function ($routes) {
        $routes->get('/', 'AplikasiController::index');
        $routes->post('save', 'AplikasiController::save');
        $routes->post('uploadLogo', 'AplikasiController::uploadLogo'); // <- route untuk Dropzone
    });


    // Role (admin only)
    $routes->group('role', ['filter' => 'auth:1'], function ($routes) {
        $routes->get('/', 'RoleController::index');
        $routes->get('create', 'RoleController::create');
        $routes->post('store', 'RoleController::store');
        $routes->get('edit/(:num)', 'RoleController::edit/$1');
        $routes->post('update/(:num)', 'RoleController::update/$1');
        $routes->get('delete/(:num)', 'RoleController::delete/$1');
        $routes->get('detail/(:num)', 'RoleController::detail/$1');
    });

    // User (admin only)
    $routes->group('user', ['filter' => 'auth:1'], function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('create', 'UserController::create');
        $routes->post('store', 'UserController::store');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update/(:num)', 'UserController::update/$1');
        $routes->get('delete/(:num)', 'UserController::delete/$1');
        $routes->get('detail/(:num)', 'UserController::detail/$1');
    });

    // Laporan
    $routes->group('laporan', function ($routes) {
        $routes->get('masuk', 'Laporan\BarangMasuk::index');
        $routes->get('masuk/export/excel', 'Laporan\BarangMasuk::exportExcel');
        $routes->get('masuk/export/pdf', 'Laporan\BarangMasuk::exportPdf');
        $routes->get('masuk/export/word', 'Laporan\BarangMasuk::exportWord');

        $routes->get('keluar', 'Laporan\BarangKeluar::index');
        $routes->get('keluar/export/excel', 'Laporan\BarangKeluar::exportExcel');
        $routes->get('keluar/export/pdf', 'Laporan\BarangKeluar::exportPdf');
        $routes->get('keluar/export/word', 'Laporan\BarangKeluar::exportWord');
    });

});
