<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_barang', 'kode_barang', 'kategori_id', 'satuan', 'jumlah_stok'];
    protected $useTimestamps = true;

    // Fungsi bantu untuk update stok
    public function adjustStok($idBarang, $jumlah, $tipe = 'tambah')
    {
        $barang = $this->find($idBarang);
        if ($barang) {
            $stokBaru = $tipe === 'tambah'
                ? $barang['jumlah_stok'] + $jumlah
                : max($barang['jumlah_stok'] - $jumlah, 0); // pastikan tidak minus

            $this->update($idBarang, ['jumlah_stok' => $stokBaru]);
        }
    }

    public function getBarangWithKategori()
    {
        return $this->select('barang.*, kategori.nama AS kategori')
            ->join('kategori', 'kategori.id = barang.kategori_id')
            ->where('barang.jumlah_stok >', 0)
            ->get()
            ->getResultArray();
    }


}
