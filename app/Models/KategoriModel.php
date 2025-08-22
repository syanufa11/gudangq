<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama'];
    protected $useTimestamps = true;

    public function getAllKategori()
    {
        $result = $this->select('nama')
            ->orderBy('nama', 'ASC')
            ->findAll();

        // Ubah menjadi array sederhana
        return array_column($result, 'nama');
    }
}
