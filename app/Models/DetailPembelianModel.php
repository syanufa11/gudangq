<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPembelianModel extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'id';

    protected $useTimestamps = true; // otomatis set created_at & updated_at
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'id_pembelian',
        'id_barang',
        'jumlah',
        'harga',
    ];

    public function getByPembelian($id_pembelian)
    {
        return $this->select('detail_pembelian.*, barang.nama_barang, barang.satuan')
            ->join('barang', 'barang.id = detail_pembelian.id_barang')
            ->where('id_pembelian', $id_pembelian)
            ->findAll();
    }

    public function getDetailPembelian($id)
    {
        return $this->select('detail_pembelian.*, barang.nama_barang, barang.kode_barang, kategori.nama as nama_kategori')
            ->join('barang', 'barang.id = detail_pembelian.id_barang', 'left')
            ->join('kategori', 'kategori.id = barang.kategori_id', 'left')
            ->where('id_pembelian', $id)
            ->findAll();
    }

}
