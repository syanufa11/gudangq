<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AplikasiModel;

class AplikasiController extends BaseController
{
    protected $aplikasiModel;

    public function __construct()
    {
        $this->aplikasiModel = new AplikasiModel();
    }

    public function index()
    {
        $aplikasi = $this->aplikasiModel->first();

        return $this->render('aplikasi', [
            'title' => 'Form Aplikasi',
            'aplikasi' => $aplikasi
        ]);
    }


    public function save()
    {
        $aplikasi = $this->aplikasiModel->first();
        $id = $aplikasi ? $aplikasi['id'] : null;

        $nama = $this->request->getPost('nama');
        $file = $this->request->getFile('logo');

        $data = ['nama' => $nama];

        // Jika ada file yang di-upload
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/logo/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            // Upload file
            $file->move($uploadPath, $fileName);
            $data['logo'] = 'uploads/logo/' . $fileName;

            // Hapus logo lama jika ada
            if ($aplikasi && !empty($aplikasi['logo']) && file_exists(FCPATH . $aplikasi['logo'])) {
                @unlink(FCPATH . $aplikasi['logo']);
            }
        }

        // Simpan ke database
        if ($id) {
            $this->aplikasiModel->update($id, $data);
            $message = 'Aplikasi berhasil diubah!';
        } else {
            $this->aplikasiModel->insert($data);
            $message = 'Aplikasi berhasil ditambahkan!';
        }

        // Set flashdata dan redirect
        session()->setFlashdata('success', $message);
        return redirect()->to('/aplikasi');
    }
}
