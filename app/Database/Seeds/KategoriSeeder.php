<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'IT EQUIPMENTS'],
            ['nama' => 'OFFICE EQUIPMENTS'],
            ['nama' => 'SPARE PART'],
            ['nama' => 'KENDARAAN DAN ALAT BERAT'],
        ];

        // Insert data ke tabel kategori
        $this->db->table('kategori')->insertBatch($data);
    }
}
