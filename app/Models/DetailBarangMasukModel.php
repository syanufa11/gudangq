<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailBarangMasukModel extends Model
{
    protected $table = 'detail_barang_masuk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_barang_masuk', 'id_barang', 'jumlah'];
    protected $useTimestamps = true;
}
