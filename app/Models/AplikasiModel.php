<?php

namespace App\Models;

use CodeIgniter\Model;

class AplikasiModel extends Model
{
    protected $table = 'aplikasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'logo']; // <- HARUS ada nama & logo

    protected $useTimestamps = true; // otomatis set created_at & updated_at
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

}
