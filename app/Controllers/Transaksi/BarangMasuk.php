<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;

use Dompdf\Dompdf;

class BarangMasuk extends BaseController
{
    protected $barangMasukModel;

    public function __construct()
    {
        $this->barangMasukModel = new BarangMasukModel();
    }

    // Daftar Barang Masuk
    public function index()
    {
        // Ambil semua data barang masuk beserta detail dan info barang
        $barangMasuk = $this->barangMasukModel->getBarangMasukDetail();

        $data = [
            'title' => 'Transaksi Barang Masuk',
            'barangMasuk' => $barangMasuk
        ];

        return $this->render('transaksi/barang_masuk/index', $data);
    }


    // Detail Barang Masuk
    public function detail($id)
    {
        // Data diambil langsung dari model
        $data = $this->barangMasukModel->withDetail($id);
        $data['title'] = 'Detail Barang Masuk';

        return $this->render('transaksi/barang_masuk/detail', $data);
    }

    public function cetak_pdf($id)
    {
        // Ambil data barang masuk + detail dari model
        $data = $this->barangMasukModel->withDetail($id);

        if (!$data['barangMasuk']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data barang masuk tidak ditemukan.");
        }

        $html = view('transaksi/barang_masuk/cetak_pdf', array_merge($this->data, [
            'barangMasuk' => $data['barangMasuk'],
            'detail' => $data['detail']
        ]));

        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Footer dengan nomor halaman
        $canvas = $dompdf->get_canvas();
        $font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
        $canvas->page_text(450, 820, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $font, 10);

        $dompdf->stream('detail_barang_masuk_' . $id . '.pdf', ['Attachment' => false]);
        exit;
    }
}
