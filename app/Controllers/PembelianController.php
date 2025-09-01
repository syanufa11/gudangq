<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PembelianModel;
use App\Models\DetailPembelianModel;
use App\Models\BarangModel;
use App\Models\BarangMasukModel;

require_once ROOTPATH . 'vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class PembelianController extends BaseController
{
    protected $pembelian;
    protected $detail;
    protected $barang;
    protected $barangMasuk;

    public function __construct()
    {
        $this->pembelian = new PembelianModel();
        $this->detail = new DetailPembelianModel();
        $this->barang = new BarangModel();
        $this->barangMasuk = new BarangMasukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pembelian',
            'pembelian' => $this->pembelian->getAllForIndex()
        ];

        // Gunakan render() agar data global otomatis tersedia di view
        return $this->render('pembelian/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pembelian',
            'barang' => $this->barang->getBarangWithKategori()
        ];

        // Gunakan render() agar otomatis merge dengan data global
        return $this->render('pembelian/form', $data);
    }

    public function edit($id)
    {
        $pembelian = $this->pembelian->find($id);
        if (!$pembelian) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to('/pembelian');
        }

        $data = [
            'title' => 'Edit Pembelian',
            'pembelian' => $pembelian,
            'barang' => $this->barang->getBarangWithKategori(),
            'detail_pembelian' => $this->detail->getByPembelian($id)
        ];

        // Gunakan render() agar otomatis merge dengan data global
        return $this->render('pembelian/form', $data);
    }

    public function store()
    {
        $post = $this->request->getPost();

        $idPembelian = $this->pembelian->insert([
            'nama_vendor' => $post['nama_vendor'],
            'alamat_vendor' => $post['alamat_vendor'],
            'tanggal_pembelian' => $post['tanggal_pembelian'],
            'nama_pembeli' => $post['nama_pembeli'],
        ], true);

        $detailBarang = [];
        foreach ($post['barang_id'] as $i => $barang_id) {
            $this->detail->insert([
                'id_pembelian' => $idPembelian,
                'id_barang' => $barang_id,
                'jumlah' => $post['jumlah'][$i],
                'harga' => $post['harga'][$i],
            ]);

            $detailBarang[] = [
                'id_barang' => $barang_id,
                'jumlah' => $post['jumlah'][$i]
            ];
        }

        $this->barangMasuk->addBarangMasuk($idPembelian, $post['tanggal_pembelian'], $detailBarang);

        session()->setFlashdata('success', 'Pembelian berhasil ditambahkan dan stok diupdate!');
        return redirect()->to('/pembelian');
    }

    public function update($id)
    {
        $post = $this->request->getPost();
        $this->pembelian->updatePembelianWithDetail($id, $post);

        session()->setFlashdata('success', 'Pembelian berhasil diperbarui dan stok diupdate!');
        return redirect()->to('/pembelian');
    }

    public function delete($id)
    {
        if ($this->pembelian->find($id)) {
            $this->pembelian->deletePembelianWithStok($id);
            session()->setFlashdata('success', 'Pembelian berhasil dihapus dan stok dikurangi!');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }
        return redirect()->to('/pembelian');
    }

    public function hapus_barang($id)
    {
        $detail = $this->detail->find($id);

        if ($detail) {
            // Kurangi stok otomatis
            $this->barang->adjustStok($detail['id_barang'], $detail['jumlah'], 'kurang');

            $this->detail->delete($id);
            session()->setFlashdata('success', 'Barang berhasil dihapus dan stok diperbarui');
        } else {
            session()->setFlashdata('error', 'Barang tidak ditemukan');
        }

        return redirect()->back();
    }

    public function detail($id)
    {
        // Ambil data pembelian dan detail
        $pembelian = $this->pembelian->find($id);
        $detail = $this->detail->getDetailPembelian($id);

        // Data khusus halaman
        $data = [
            'pembelian' => $pembelian,
            'detail' => $detail,
            'title' => 'Detail Pembelian'
        ];

        // Gunakan render() dari BaseController agar otomatis merge dengan globalData
        return $this->render('pembelian/detail', $data);
    }

    public function cetak_pdf($id)
    {
        $pembelian = $this->pembelian->find($id);
        if (!$pembelian) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data pembelian tidak ditemukan.");
        }

        $detail = $this->detail->getDetailPembelian($id);

        // Merge data global dari BaseController agar $aplikasi tersedia
        $html = view('pembelian/cetak_pdf', array_merge($this->data, [
            'pembelian' => $pembelian,
            'detail' => $detail
        ]));

        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', true); // jika pakai URL
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Footer dengan nomor halaman
        $canvas = $dompdf->get_canvas();
        $font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
        $canvas->page_text(450, 820, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $font, 10);

        $dompdf->stream('detail_pembelian_' . $id . '.pdf', ['Attachment' => false]);
        exit;
    }

    public function export()
    {
        $kategori = $this->request->getGet('kategori');
        $pembelianTerbaru = $this->pembelian->getPembelianTerbaru($kategori);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header tabel
        $headers = ['No', 'Tanggal', 'Vendor', 'Nama Barang', 'Kategori', 'Jumlah', 'Satuan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getStyle($col . '1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFCCE5FF');
            $sheet->getStyle($col . '1')->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $col++;
        }

        // Isi data
        $row = 2;
        $no = 1;

        foreach ($pembelianTerbaru as $p) {
            // kalau tidak ada barang yang cocok kategori, skip
            if (empty($p['barang'])) {
                continue;
            }

            $startRow = $row;

            foreach ($p['barang'] as $item) {
                $sheet->setCellValue('D' . $row, $item['nama_barang']);
                $sheet->setCellValue('E' . $row, $item['kategori'] ?? '');
                $sheet->setCellValue('F' . $row, $item['jumlah']);
                $sheet->setCellValue('G' . $row, $item['satuan'] ?? '');

                foreach (range('A', 'G') as $col) {
                    $sheet->getStyle($col . $row)->getBorders()->getAllBorders()
                        ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                }
                $row++;
            }

            $endRow = $row - 1;

            if ($endRow > $startRow) {
                $sheet->mergeCells("A{$startRow}:A{$endRow}");
                $sheet->mergeCells("B{$startRow}:B{$endRow}");
                $sheet->mergeCells("C{$startRow}:C{$endRow}");
            }

            $sheet->setCellValue("A{$startRow}", $no++);
            $sheet->setCellValue("B{$startRow}", tgl_indo($p['tanggal_pembelian']));
            $sheet->setCellValue("C{$startRow}", $p['nama_vendor']);
        }

        // Auto width kolom
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama file
        $fileKategori = $kategori ? '_' . preg_replace('/\s+/', '_', strtolower($kategori)) : '';
        $filename = 'pembelian_terbaru' . $fileKategori . '_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

}
