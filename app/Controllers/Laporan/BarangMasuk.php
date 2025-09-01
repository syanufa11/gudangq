<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\TextAlignment;
use Dompdf\Dompdf;

class BarangMasuk extends BaseController
{
    protected $barangMasukModel;

    public function __construct()
    {
        $this->barangMasukModel = new BarangMasukModel();
    }

    public function index()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $barangMasuk = $this->barangMasukModel->getBarangMasukDetail($dari, $sampai);

        $data = [
            'title' => 'Laporan Barang Masuk',
            'barangMasuk' => $barangMasuk
        ];

        return $this->render('laporan/barang_masuk/index', $data);
    }

    // ---------------- Export Excel ----------------
    public function exportExcel()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $raw = $this->barangMasukModel->getBarangMasukDetail($dari, $sampai);

        $grouped = [];
        foreach ($raw as $bm) {
            $grouped[$bm['id']]['info'] = [
                'tanggal_masuk' => $bm['tanggal_masuk'],
                'nama_vendor' => $bm['nama_vendor'],
                'alamat_vendor' => $bm['alamat_vendor'],
                'tanggal_pembelian' => $bm['tanggal_pembelian'],
                'nama_pembeli' => $bm['nama_pembeli'],
            ];
            foreach ($bm['detail'] as $det) {
                $grouped[$bm['id']]['detail'][] = [
                    'kode_barang' => $det['kode_barang'],
                    'nama_barang' => $det['nama_barang'],
                    'nama_kategori' => $det['nama_kategori'],
                    'jumlah' => $det['jumlah'],
                    'satuan' => $det['satuan'],
                    'jumlah_stok' => $det['jumlah_stok'],
                ];
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['No', 'Tanggal Masuk', 'Vendor', 'Alamat Vendor', 'Tanggal Pembelian', 'Nama Pembeli', 'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Satuan', 'Stok Tersedia'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getStyle($col . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $col++;
        }

        $no = 1;
        $row = 2;
        foreach ($grouped as $bm) {
            $startRow = $row;
            foreach ($bm['detail'] as $det) {
                $sheet->setCellValue("G{$row}", $det['kode_barang']);
                $sheet->setCellValue("H{$row}", $det['nama_barang']);
                $sheet->setCellValue("I{$row}", $det['nama_kategori']);
                $sheet->setCellValue("J{$row}", $det['jumlah']);
                $sheet->setCellValue("K{$row}", $det['satuan']);
                $sheet->setCellValue("L{$row}", $det['jumlah_stok']);
                $sheet->getStyle("A{$row}:L{$row}")
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("A{$row}:L{$row}")
                    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true);
                $row++;
            }
            $endRow = $row - 1;

            if ($endRow > $startRow) {
                foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $c) {
                    $sheet->mergeCells("{$c}{$startRow}:{$c}{$endRow}");
                    $sheet->getStyle("{$c}{$startRow}")
                        ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
            }

            $sheet->setCellValue("A{$startRow}", $no++);
            $sheet->setCellValue("B{$startRow}", tgl_indo($bm['info']['tanggal_masuk']));
            $sheet->setCellValue("C{$startRow}", $bm['info']['nama_vendor']);
            $sheet->setCellValue("D{$startRow}", $bm['info']['alamat_vendor']);
            $sheet->setCellValue("E{$startRow}", tgl_indo($bm['info']['tanggal_pembelian']));
            $sheet->setCellValue("F{$startRow}", $bm['info']['nama_pembeli']);
        }

        foreach (range('A', 'L') as $c)
            $sheet->getColumnDimension($c)->setAutoSize(true);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $fileName = "Laporan_Barang_Masuk_" . ($dari ? tgl_indo($dari) : 'awal') . "_sampai_" . ($sampai ? tgl_indo($sampai) : 'akhir') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    // ---------------- Export Word ----------------

    public function exportWord()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $raw = $this->barangMasukModel->getBarangMasukDetail($dari, $sampai);

        // Kelompokkan per transaksi
        $grouped = [];
        foreach ($raw as $bm) {
            $grouped[$bm['id']]['info'] = [
                'tanggal_masuk' => $bm['tanggal_masuk'],
                'nama_vendor' => $bm['nama_vendor'],
                'alamat_vendor' => $bm['alamat_vendor'],
                'tanggal_pembelian' => $bm['tanggal_pembelian'],
                'nama_pembeli' => $bm['nama_pembeli'],
            ];
            foreach ($bm['detail'] as $det) {
                $grouped[$bm['id']]['detail'][] = [
                    'kode_barang' => $det['kode_barang'],
                    'nama_barang' => $det['nama_barang'],
                    'nama_kategori' => $det['nama_kategori'],
                    'jumlah' => $det['jumlah'],
                    'satuan' => $det['satuan'],
                    'jumlah_stok' => $det['jumlah_stok'],
                ];
            }
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection(['orientation' => 'landscape']);

        // Table style
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
        ];
        $phpWord->addTableStyle('BarangMasukTable', $tableStyle);
        $table = $section->addTable('BarangMasukTable');

        // Header
        $headers = ['No', 'Tanggal Masuk', 'Vendor', 'Alamat Vendor', 'Tanggal Pembelian', 'Nama Pembeli', 'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Satuan', 'Stok Tersedia'];
        $table->addRow();
        foreach ($headers as $h) {
            $table->addCell()->addText($h, ['bold' => true], ['alignment' => Jc::CENTER]);
        }

        $no = 1;
        foreach ($grouped as $bm) {
            $details = $bm['detail'];
            $rowspan = count($details);

            foreach ($details as $index => $det) {
                $table->addRow();

                if ($index === 0) {
                    // Merge vertikal dengan VMerge
                    $table->addCell(null, ['vMerge' => 'restart'])->addText($no++, [], ['alignment' => Jc::CENTER]);
                    $table->addCell(null, ['vMerge' => 'restart'])->addText(tgl_indo($bm['info']['tanggal_masuk']), [], ['alignment' => Jc::CENTER]);
                    $table->addCell(null, ['vMerge' => 'restart'])->addText($bm['info']['nama_vendor']);
                    $table->addCell(null, ['vMerge' => 'restart'])->addText($bm['info']['alamat_vendor']);
                    $table->addCell(null, ['vMerge' => 'restart'])->addText(tgl_indo($bm['info']['tanggal_pembelian']), [], ['alignment' => Jc::CENTER]);
                    $table->addCell(null, ['vMerge' => 'restart'])->addText($bm['info']['nama_pembeli']);
                } else {
                    // lanjut merge vertikal
                    $table->addCell(null, ['vMerge' => 'continue']);
                    $table->addCell(null, ['vMerge' => 'continue']);
                    $table->addCell(null, ['vMerge' => 'continue']);
                    $table->addCell(null, ['vMerge' => 'continue']);
                    $table->addCell(null, ['vMerge' => 'continue']);
                    $table->addCell(null, ['vMerge' => 'continue']);
                }

                // Kolom detail
                $table->addCell()->addText($det['kode_barang']);
                $table->addCell()->addText($det['nama_barang']);
                $table->addCell()->addText($det['nama_kategori']);
                $table->addCell()->addText($det['jumlah'], [], ['alignment' => Jc::CENTER]);
                $table->addCell()->addText($det['satuan']);
                $table->addCell()->addText($det['jumlah_stok'], [], ['alignment' => Jc::CENTER]);
            }
        }

        $fileName = "Laporan_Barang_Masuk_" . ($dari ? tgl_indo($dari) : 'awal') . "_sampai_" . ($sampai ? tgl_indo($sampai) : 'akhir') . ".docx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007')->save('php://output');
        exit;
    }



    // ---------------- Export PDF ----------------
    public function exportPdf()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $raw = $this->barangMasukModel->getBarangMasukDetail($dari, $sampai);

        // Kelompokkan per transaksi
        $grouped = [];
        foreach ($raw as $bm) {
            $grouped[$bm['id']]['info'] = [
                'tanggal_masuk' => $bm['tanggal_masuk'],
                'nama_vendor' => $bm['nama_vendor'],
                'alamat_vendor' => $bm['alamat_vendor'],
                'tanggal_pembelian' => $bm['tanggal_pembelian'],
                'nama_pembeli' => $bm['nama_pembeli'],
            ];
            foreach ($bm['detail'] as $det) {
                $grouped[$bm['id']]['detail'][] = [
                    'kode_barang' => $det['kode_barang'],
                    'nama_barang' => $det['nama_barang'],
                    'nama_kategori' => $det['nama_kategori'],
                    'jumlah' => $det['jumlah'],
                    'satuan' => $det['satuan'],
                    'jumlah_stok' => $det['jumlah_stok'],
                ];
            }
        }

        $html = '<table border="1" cellspacing="0" cellpadding="5" width="100%" style="border-collapse: collapse;">';
        $html .= '<tr style="background-color:#DDDDDD; text-align:center;">
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Vendor</th>
                <th>Alamat Vendor</th>
                <th>Tanggal Pembelian</th>
                <th>Nama Pembeli</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Stok Tersedia</th>
              </tr>';

        $no = 1;
        foreach ($grouped as $bm) {
            $details = $bm['detail'];
            $rowspan = count($details);
            $first = true;

            foreach ($details as $det) {
                $html .= '<tr>';

                if ($first) {
                    // Merge cell vertikal dengan rowspan
                    $html .= "<td rowspan='{$rowspan}' style='text-align:center;'>{$no}</td>";
                    $html .= "<td rowspan='{$rowspan}' style='text-align:center;'>" . tgl_indo($bm['info']['tanggal_masuk']) . "</td>";
                    $html .= "<td rowspan='{$rowspan}'>{$bm['info']['nama_vendor']}</td>";
                    $html .= "<td rowspan='{$rowspan}'>{$bm['info']['alamat_vendor']}</td>";
                    $html .= "<td rowspan='{$rowspan}' style='text-align:center;'>" . tgl_indo($bm['info']['tanggal_pembelian']) . "</td>";
                    $html .= "<td rowspan='{$rowspan}'>{$bm['info']['nama_pembeli']}</td>";
                    $first = false;
                    $no++;
                }

                $html .= "<td>{$det['kode_barang']}</td>";
                $html .= "<td>{$det['nama_barang']}</td>";
                $html .= "<td>{$det['nama_kategori']}</td>";
                $html .= "<td style='text-align:center;'>{$det['jumlah']}</td>";
                $html .= "<td>{$det['satuan']}</td>";
                $html .= "<td style='text-align:center;'>{$det['jumlah_stok']}</td>";
                $html .= '</tr>';
            }
        }

        $html .= '</table>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Landscape
        $dompdf->render();

        $fileName = "Laporan_Barang_Masuk_" . ($dari ? tgl_indo($dari) : 'awal') . "_sampai_" . ($sampai ? tgl_indo($sampai) : 'akhir') . ".pdf";
        $dompdf->stream($fileName, ["Attachment" => true]);
        exit;
    }


}
