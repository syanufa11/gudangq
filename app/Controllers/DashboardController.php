<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\BarangModel;
use App\Models\PembelianModel;
use App\Models\BarangMasukModel;
use App\Models\BarangKeluarModel;

class DashboardController extends BaseController
{
    protected $kategoriModel;
    protected $barangModel;
    protected $pembelianModel;
    protected $masukModel;
    protected $keluarModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        // Load model yang dibutuhkan
        $this->kategoriModel = new KategoriModel();
        $this->barangModel = new BarangModel();
        $this->pembelianModel = new PembelianModel();
        $this->masukModel = new BarangMasukModel();
        $this->keluarModel = new BarangKeluarModel();
    }

    public function index()
    {
        $today = date('Y-m-d');

        // Total barang masuk
        $totalBarangMasuk = (int) $this->masukModel
            ->selectSum('detail_barang_masuk.jumlah', 'total')
            ->join('detail_barang_masuk', 'barang_masuk.id = detail_barang_masuk.id_barang_masuk')
            ->first()['total'] ?? 0;

        // Total barang keluar
        $totalBarangKeluar = (int) $this->keluarModel
            ->selectSum('detail_barang_keluar.jumlah', 'total')
            ->join('detail_barang_keluar', 'barang_keluar.id = detail_barang_keluar.id_barang_keluar')
            ->first()['total'] ?? 0;

        // Total stok barang
        $totalBarang = (int) $this->barangModel->selectSum('jumlah_stok', 'total')->first()['total'] ?? 0;

        // Total kategori
        $totalKategori = $this->kategoriModel->countAllResults();

        // Barang masuk/keluar hari ini
        $barangMasukHariIni = (int) $this->masukModel
            ->selectSum('detail_barang_masuk.jumlah', 'total')
            ->join('detail_barang_masuk', 'barang_masuk.id = detail_barang_masuk.id_barang_masuk')
            ->where('tanggal_masuk', $today)
            ->first()['total'] ?? 0;

        $barangKeluarHariIni = (int) $this->keluarModel
            ->selectSum('detail_barang_keluar.jumlah', 'total')
            ->join('detail_barang_keluar', 'barang_keluar.id = detail_barang_keluar.id_barang_keluar')
            ->where('tanggal_keluar', $today)
            ->first()['total'] ?? 0;

        // Stok per kategori
        $stokPerKategori = $this->barangModel
            ->select('kategori.nama, SUM(jumlah_stok) as total_stok')
            ->join('kategori', 'kategori.id = barang.kategori_id')
            ->groupBy('kategori_id')
            ->findAll();


        // Chart barang masuk vs keluar per bulan
        $masukKeluarPerBulan = $this->getMasukKeluarPerBulan();

        $data = [
            'title' => 'Dashboard',
            'totalKategori' => $totalKategori,
            'totalBarang' => $totalBarang,
            'totalBarangMasuk' => $totalBarangMasuk,
            'totalBarangKeluar' => $totalBarangKeluar,
            'barangMasukHariIni' => $barangMasukHariIni,
            'barangKeluarHariIni' => $barangKeluarHariIni,
            'stokPerKategori' => $stokPerKategori,
            'pembelianTerbaru' => $this->pembelianModel->getPembelianTerbaru(),
            'kategoriList' => $this->kategoriModel->getAllKategori(),
            'masukKeluarPerBulan' => $masukKeluarPerBulan,
        ];

        return $this->render('dashboard', $data);
    }

    private function getMasukKeluarPerBulan()
    {
        $bulan = [];
        $masuk = [];
        $keluar = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = date('M', mktime(0, 0, 0, $i, 1));

            // Total barang masuk per bulan
            $totalMasuk = (int) $this->masukModel
                ->selectSum('detail_barang_masuk.jumlah', 'total')
                ->join('detail_barang_masuk', 'barang_masuk.id = detail_barang_masuk.id_barang_masuk')
                ->where('MONTH(tanggal_masuk)', $i)
                ->first()['total'] ?? 0;
            $masuk[] = $totalMasuk;

            // Total barang keluar per bulan
            $totalKeluar = (int) $this->keluarModel
                ->selectSum('detail_barang_keluar.jumlah', 'total')
                ->join('detail_barang_keluar', 'barang_keluar.id = detail_barang_keluar.id_barang_keluar')
                ->where('MONTH(tanggal_keluar)', $i)
                ->first()['total'] ?? 0;
            $keluar[] = $totalKeluar;
        }

        return [
            'bulan' => $bulan,
            'masuk' => $masuk,
            'keluar' => $keluar,
        ];
    }
}
