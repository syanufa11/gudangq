<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailBarangKeluarModel extends Model
{
    protected $table = 'detail_barang_keluar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_barang_keluar', 'id_barang', 'jumlah'];
    protected $useTimestamps = true;

    /**
     * Ambil detail barang keluar beserta nama barang
     *
     * @param int $id_barang_keluar
     * @return array
     */

    public function getDetailBarangKeluar($id)
    {
        return $this->select('detail_barang_keluar.*, barang.nama_barang, barang.kode_barang, kategori.nama as nama_kategori, barang.satuan, barang.jumlah_stok')
            ->join('barang', 'barang.id = detail_barang_keluar.id_barang', 'left')
            ->join('kategori', 'kategori.id = barang.kategori_id', 'left')
            ->where('id_barang_keluar', $id)
            ->findAll();
    }

}
