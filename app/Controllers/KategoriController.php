<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Kategori',
            'kategori' => $this->kategori->orderBy('id', 'DESC')->findAll()
        ];

        // Gunakan render() agar data global otomatis tersedia di view
        return $this->render('kategori', $data);
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');

        if (!$nama) {
            session()->setFlashdata('error', 'Nama kategori wajib diisi!');
            return redirect()->to('/kategori');
        }

        if ($id) {
            $this->kategori->update($id, ['nama' => $nama]);
            session()->setFlashdata('success', 'Kategori berhasil diperbarui!');
        } else {
            $this->kategori->insert(['nama' => $nama]);
            session()->setFlashdata('success', 'Kategori berhasil ditambahkan!');
        }

        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        if ($this->kategori->find($id)) {
            $this->kategori->delete($id);
            session()->setFlashdata('success', 'Kategori berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }

        return redirect()->to('/kategori');
    }
}
