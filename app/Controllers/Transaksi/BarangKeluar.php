<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use App\Models\DetailBarangKeluarModel;
use App\Models\BarangModel;

use Dompdf\Dompdf;

class BarangKeluar extends BaseController
{
    protected $barangKeluarModel;
    protected $detailKeluarModel;
    protected $barangModel;

    public function __construct()
    {
        $this->barangKeluarModel = new BarangKeluarModel();
        $this->detailKeluarModel = new DetailBarangKeluarModel();
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Transaksi Barang Keluar',
            'barangKeluar' => $this->barangKeluarModel->getBarangKeluarDetail()
        ];

        return $this->render('transaksi/barang_keluar/index', $data);
    }


    public function create()
    {
        $data = [
            'title' => 'Tambah Barang Keluar',
            'barang' => $this->barangModel->getBarangWithKategori(),
            'barangModel' => $this->barangModel
        ];

        // Gunakan render() agar data global otomatis tersedia di view
        return $this->render('transaksi/barang_keluar/form', $data);
    }

    public function store()
    {
        $post = $this->request->getPost();

        if (empty($post['id_barang']) || empty($post['jumlah'])) {
            return redirect()->back()->with('error', 'Data barang tidak lengkap.');
        }

        $this->barangKeluarModel->transBegin();

        try {
            $this->barangKeluarModel->insert([
                'tanggal_keluar' => $post['tanggal_keluar'],
                'keterangan' => $post['keterangan']
            ]);
            $idKeluar = $this->barangKeluarModel->getInsertID();

            foreach ($post['id_barang'] as $i => $id_barang) {
                $jumlah = (int) $post['jumlah'][$i];
                $barang = $this->barangModel->find($id_barang);

                if (!$barang)
                    continue;

                // Kurangi stok
                $stokBaru = $barang['jumlah_stok'] - $jumlah;
                if ($stokBaru < 0) {
                    $this->barangKeluarModel->transRollback();
                    return redirect()->back()->with('error', "Stok {$barang['nama_barang']} tidak cukup.");
                }

                // Simpan detail
                $this->detailKeluarModel->insert([
                    'id_barang_keluar' => $idKeluar,
                    'id_barang' => $id_barang,
                    'jumlah' => $jumlah
                ]);

                // Update stok barang
                $this->barangModel->update($id_barang, ['jumlah_stok' => $stokBaru]);
            }

            $this->barangKeluarModel->transCommit();
            return redirect()->to('transaksi/keluar')->with('success', 'Barang Keluar berhasil ditambahkan.');
        } catch (\Exception $e) {
            $this->barangKeluarModel->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $barangKeluar = $this->barangKeluarModel->find($id);
        if (!$barangKeluar) {
            return redirect()->to('transaksi/keluar')->with('error', 'Data tidak ditemukan.');
        }

        $detail = $this->detailKeluarModel
            ->select('detail_barang_keluar.*, barang.nama_barang')
            ->join('barang', 'barang.id = detail_barang_keluar.id_barang')
            ->where('id_barang_keluar', $id)
            ->findAll();

        foreach ($detail as &$d) {
            $barang = $this->barangModel->find($d['id_barang']);
            $d['stok_tersedia'] = $barang ? $barang['jumlah_stok'] : 0;
        }

        $data = [
            'title' => 'Edit Barang Keluar',
            'barangKeluar' => $barangKeluar,
            'detail' => $detail,
            'barang' => $this->barangModel->getBarangWithKategori()
        ];

        // Gunakan render() agar data global otomatis tersedia di view
        return $this->render('transaksi/barang_keluar/form', $data);
    }

    public function update($id)
    {
        $post = $this->request->getPost();
        $detailLama = $this->detailKeluarModel
            ->where('id_barang_keluar', $id)
            ->findAll();

        $this->barangKeluarModel->transBegin();

        try {
            // Update header
            $this->barangKeluarModel->update($id, [
                'tanggal_keluar' => $post['tanggal_keluar'],
                'keterangan' => $post['keterangan']
            ]);

            // Array detail lama keyed by id_barang
            $detailLamaArr = [];
            foreach ($detailLama as $d) {
                $detailLamaArr[$d['id_barang']] = $d['jumlah'];
            }

            $processedBarang = [];

            foreach ($post['id_barang'] as $i => $id_barang) {
                $jumlahBaru = (int) $post['jumlah'][$i];
                $barang = $this->barangModel->find($id_barang);
                if (!$barang)
                    continue;

                // Hitung stok baru dengan benar
                $stokBaru = $barang['jumlah_stok'] - $jumlahBaru;

                if ($stokBaru < 0) {
                    $this->barangKeluarModel->transRollback();
                    return redirect()->back()->with('error', "Stok {$barang['nama_barang']} tidak cukup.");
                }

                // Update stok
                $this->barangModel->update($id_barang, ['jumlah_stok' => $stokBaru]);

                if (isset($detailLamaArr[$id_barang])) {
                    // Update detail lama
                    $this->detailKeluarModel
                        ->where('id_barang_keluar', $id)
                        ->where('id_barang', $id_barang)
                        ->update(null, ['jumlah' => $jumlahBaru]);
                } else {
                    // Insert detail baru
                    $this->detailKeluarModel->insert([
                        'id_barang_keluar' => $id,
                        'id_barang' => $id_barang,
                        'jumlah' => $jumlahBaru
                    ]);
                }

                $processedBarang[] = $id_barang;
            }


            // Hapus detail yang tidak ada di form (dikembalikan stok)
            foreach ($detailLamaArr as $id_barangLama => $jumlahLama) {
                if (!in_array($id_barangLama, $processedBarang)) {
                    $barang = $this->barangModel->find($id_barangLama);
                    if ($barang) {
                        $this->barangModel->update($id_barangLama, [
                            'jumlah_stok' => $barang['jumlah_stok'] + $jumlahLama
                        ]);
                    }
                    $this->detailKeluarModel
                        ->where('id_barang_keluar', $id)
                        ->where('id_barang', $id_barangLama)
                        ->delete();
                }
            }

            $this->barangKeluarModel->transCommit();
            return redirect()->to('transaksi/keluar')->with('success', 'Barang Keluar berhasil diupdate.');
        } catch (\Exception $e) {
            $this->barangKeluarModel->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function delete($id)
    {
        $this->barangKeluarModel->transBegin();

        try {
            $detail = $this->detailKeluarModel->where('id_barang_keluar', $id)->findAll();
            foreach ($detail as $d) {
                $barang = $this->barangModel->find($d['id_barang']);
                if ($barang) {
                    $this->barangModel->update($d['id_barang'], [
                        'jumlah_stok' => $barang['jumlah_stok'] + $d['jumlah']
                    ]);
                }
            }

            $this->detailKeluarModel->where('id_barang_keluar', $id)->delete();
            $this->barangKeluarModel->delete($id);

            $this->barangKeluarModel->transCommit();
            return redirect()->to('transaksi/keluar')->with('success', 'Barang Keluar berhasil dihapus.');
        } catch (\Exception $e) {
            $this->barangKeluarModel->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Detail Barang Keluar',
            'barangKeluar' => $this->barangKeluarModel->find($id),
            'detail' => $this->detailKeluarModel->getDetailBarangKeluar($id),
            'barangAll' => $this->barangModel->getBarangWithKategori()
        ];

        // Gunakan render() agar data global otomatis tersedia di view
        return $this->render('transaksi/barang_keluar/detail', $data);
    }

    public function cetak_pdf($id)
    {
        $barangKeluar = $this->barangKeluarModel->find($id);
        if (!$barangKeluar) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data barang keluar tidak ditemukan.");
        }

        // Ambil detail barang keluar langsung dari model
        $detail = $this->detailKeluarModel->getDetailBarangKeluar($id);

        $html = view('transaksi/barang_keluar/cetak_pdf', array_merge($this->data, [
            'barangKeluar' => $barangKeluar,
            'detail' => $detail,
            'barangAll' => $this->barangModel->getBarangWithKategori()
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

        $dompdf->stream('detail_barang_keluar_' . $id . '.pdf', ['Attachment' => false]);
        exit;
    }


}
