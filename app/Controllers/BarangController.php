<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\KategoriModel;

class BarangController extends BaseController
{
    protected $barang;
    protected $kategori;

    public function __construct()
    {
        $this->barang = new BarangModel();
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Barang',
            'barang' => $this->barang
                ->select('barang.*, kategori.nama as kategori_nama')
                ->join('kategori', 'kategori.id = barang.kategori_id', 'left')
                ->orderBy('barang.id', 'DESC')
                ->findAll(),
            'kategori' => $this->kategori->findAll()
        ];

        // Gunakan render() agar data global otomatis tersedia di view
        return $this->render('barang', $data);
    }

    public function generateKode()
    {
        $last = $this->barang->orderBy('id', 'DESC')->first();
        $nomor = $last ? ((int) substr($last['kode_barang'], 4)) + 1 : 1;
        $kode_barang = 'BRG-' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
        return $this->response->setBody($kode_barang);
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $nama_barang = $this->request->getPost('nama_barang');
        $kode_barang = $this->request->getPost('kode_barang');
        $kategori_id = $this->request->getPost('kategori_id');
        $satuan = $this->request->getPost('satuan');
        $jumlah_stok = $this->request->getPost('jumlah_stok');

        if (!$nama_barang || !$kode_barang || !$kategori_id || !$satuan || $jumlah_stok === '') {
            session()->setFlashdata('error', 'Semua field wajib diisi!');
            return redirect()->to('/barang');
        }

        $data = [
            'nama_barang' => $nama_barang,
            'kode_barang' => $kode_barang,
            'kategori_id' => $kategori_id,
            'satuan' => $satuan,
            'jumlah_stok' => $jumlah_stok,
        ];

        if ($id) {
            $this->barang->update($id, $data);
            session()->setFlashdata('success', 'Barang berhasil diperbarui!');
        } else {
            $this->barang->insert($data);
            session()->setFlashdata('success', 'Barang berhasil ditambahkan!');
        }

        return redirect()->to('/barang');
    }

    public function delete($id)
    {
        if ($this->barang->find($id)) {
            $this->barang->delete($id);
            session()->setFlashdata('success', 'Barang berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }

        return redirect()->to('/barang');
    }
}
