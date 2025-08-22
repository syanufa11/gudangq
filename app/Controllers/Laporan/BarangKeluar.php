<?php

namespace App\Controllers\laporan;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;

class BarangKeluar extends BaseController
{
    protected $barangKeluarModel;

    public function __construct()
    {
        $this->barangKeluarModel = new BarangKeluarModel();
    }

    // Halaman utama laporan
    public function index()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $barangKeluar = $this->barangKeluarModel->getBarangKeluarDetail($dari, $sampai);

        $data = [
            'title' => 'Laporan Barang Keluar',
            'barangKeluar' => $barangKeluar
        ];

        return $this->render('laporan/barang_keluar/index', $data);
    }

    // Export Excel
    public function exportExcel()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $grouped = $this->barangKeluarModel->getBarangKeluarDetail($dari, $sampai);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['No', 'Tanggal Keluar', 'Keterangan', 'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Satuan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getStyle($col . '1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $col++;
        }

        $no = 1;
        $row = 2;
        foreach ($grouped as $bk) {
            $startRow = $row;
            foreach ($bk['detail'] as $det) {
                $sheet->setCellValue("D{$row}", $det['kode_barang'] ?? '-');
                $sheet->setCellValue("E{$row}", $det['nama_barang'] ?? '-');
                $sheet->setCellValue("F{$row}", $det['nama_kategori'] ?? '-');
                $sheet->setCellValue("G{$row}", $det['jumlah'] ?? 0);
                $sheet->setCellValue("H{$row}", $det['satuan'] ?? '-');
                $sheet->getStyle("A{$row}:H{$row}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $row++;
            }
            $endRow = $row - 1;

            // Merge untuk transaksi
            $sheet->mergeCells("A{$startRow}:A{$endRow}");
            $sheet->mergeCells("B{$startRow}:B{$endRow}");
            $sheet->mergeCells("C{$startRow}:C{$endRow}");

            $sheet->setCellValue("A{$startRow}", $no++);
            $sheet->setCellValue("B{$startRow}", tgl_indo($bk['tanggal_keluar'] ?? ''));
            $sheet->setCellValue("C{$startRow}", $bk['keterangan'] ?? '-');
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $fileName = "Laporan_Barang_Keluar_" . ($dari ? tgl_indo($dari) : 'awal') . "_sampai_" . ($sampai ? tgl_indo($sampai) : 'akhir') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    // Export Word
    public function exportWord()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $grouped = $this->barangKeluarModel->getBarangKeluarDetail($dari, $sampai);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection(['orientation' => 'landscape']);
        $tableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
        $phpWord->addTableStyle('BarangKeluarTable', $tableStyle);
        $table = $section->addTable('BarangKeluarTable');

        // Header
        $headers = ['No', 'Tanggal Keluar', 'Keterangan', 'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Satuan'];
        $table->addRow();
        foreach ($headers as $header) {
            $table->addCell()->addText($header, ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        }

        $no = 1;
        foreach ($grouped as $bk) {
            $details = $bk['detail'];
            $rowspan = count($details);
            foreach ($details as $i => $det) {
                $table->addRow();
                if ($i === 0) {
                    $table->addCell(null, ['vMerge' => 'restart'])->addText($no++);
                    $table->addCell(null, ['vMerge' => 'restart'])->addText(tgl_indo($bk['tanggal_keluar'] ?? ''));
                    $table->addCell(null, ['vMerge' => 'restart'])->addText($bk['keterangan'] ?? '-');
                } else {
                    $table->addCell(null, ['vMerge' => 'continue']);
                    $table->addCell(null, ['vMerge' => 'continue']);
                    $table->addCell(null, ['vMerge' => 'continue']);
                }

                $table->addCell()->addText($det['kode_barang'] ?? '-');
                $table->addCell()->addText($det['nama_barang'] ?? '-');
                $table->addCell()->addText($det['nama_kategori'] ?? '-');
                $table->addCell()->addText($det['jumlah'] ?? 0);
                $table->addCell()->addText($det['satuan'] ?? '-');
            }
        }

        $fileName = "Laporan_Barang_Keluar_" . ($dari ? tgl_indo($dari) : 'awal') . "_sampai_" . ($sampai ? tgl_indo($sampai) : 'akhir') . ".docx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        IOFactory::createWriter($phpWord, 'Word2007')->save('php://output');
        exit;
    }

    // Export PDF
    public function exportPdf()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        // Ambil data dari model, pastikan getBarangKeluarDetail mengembalikan array
        $grouped = $this->barangKeluarModel->getBarangKeluarDetail($dari, $sampai);

        $html = '<table border="1" cellspacing="0" cellpadding="5" width="100%" style="border-collapse: collapse;">';
        $html .= '<tr style="background-color:#DDDDDD; text-align:center;">
        <th>No</th><th>Tanggal Keluar</th><th>Keterangan</th>
        <th>Kode Barang</th><th>Nama Barang</th><th>Kategori</th>
        <th>Jumlah</th><th>Satuan</th></tr>';

        $no = 1;

        if (!empty($grouped)) {
            foreach ($grouped as $bk) {
                // Pastikan 'detail' ada dan berupa array
                $details = isset($bk['detail']) && is_array($bk['detail']) ? $bk['detail'] : [];
                $rowspan = count($details) > 0 ? count($details) : 1;
                $first = true;

                // Jika tidak ada detail, tampilkan satu baris saja
                if (empty($details)) {
                    $html .= '<tr>';
                    $html .= "<td style='text-align:center;'>{$no}</td>";
                    $html .= "<td style='text-align:center;'>" . ($bk['tanggal_keluar'] ?? '-') . "</td>";
                    $html .= "<td>" . ($bk['keterangan'] ?? '-') . "</td>";
                    $html .= "<td colspan='5' style='text-align:center;'>-</td>";
                    $html .= '</tr>';
                    $no++;
                    continue;
                }

                foreach ($details as $det) {
                    $html .= '<tr>';
                    if ($first) {
                        $html .= "<td rowspan='{$rowspan}' style='text-align:center;'>{$no}</td>";
                        $html .= "<td rowspan='{$rowspan}' style='text-align:center;'>" . ($bk['tanggal_keluar'] ?? '-') . "</td>";
                        $html .= "<td rowspan='{$rowspan}'>" . ($bk['keterangan'] ?? '-') . "</td>";
                        $first = false;
                        $no++;
                    }

                    $html .= "<td>" . ($det['kode_barang'] ?? '-') . "</td>";
                    $html .= "<td>" . ($det['nama_barang'] ?? '-') . "</td>";
                    $html .= "<td>" . ($det['nama_kategori'] ?? '-') . "</td>";
                    $html .= "<td style='text-align:center;'>" . ($det['jumlah'] ?? 0) . "</td>";
                    $html .= "<td>" . ($det['satuan'] ?? '-') . "</td>";
                    $html .= '</tr>';
                }
            }
        } else {
            $html .= '<tr><td colspan="8" style="text-align:center;">Tidak ada data</td></tr>';
        }

        $html .= '</table>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = "Laporan_Barang_Keluar_" . ($dari ? $dari : 'awal') . "_sampai_" . ($sampai ? $sampai : 'akhir') . ".pdf";
        $dompdf->stream($fileName, ["Attachment" => true]);
        exit;
    }

}
