<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table = 'barang_keluar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_transaksi', 'tanggal_keluar', 'keterangan', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getBarangKeluarDetail($dari = null, $sampai = null)
    {
        $builder = $this->db->table('detail_barang_keluar dbk')
            ->select('
            bk.id, bk.tanggal_keluar, bk.keterangan, 
            b.id as id_barang, b.kode_barang, b.nama_barang, b.satuan, 
            k.id as id_kategori, k.nama as nama_kategori, dbk.jumlah
        ')
            ->join('barang_keluar bk', 'dbk.id_barang_keluar = bk.id')
            ->join('barang b', 'dbk.id_barang = b.id')
            ->join('kategori k', 'b.kategori_id = k.id');

        if ($dari) {
            $builder->where('bk.tanggal_keluar >=', $dari);
        }
        if ($sampai) {
            $builder->where('bk.tanggal_keluar <=', $sampai);
        }

        $rows = $builder->orderBy('bk.id', 'DESC')->get()->getResultArray();

        $result = [];
        foreach ($rows as $row) {
            $id = $row['id'];
            if (!isset($result[$id])) {
                $result[$id] = [
                    'id' => $row['id'],
                    'tanggal_keluar' => $row['tanggal_keluar'],
                    'keterangan' => $row['keterangan'],
                    'detail' => []
                ];
            }

            $result[$id]['detail'][] = [
                'id_barang' => $row['id_barang'],
                'kode_barang' => $row['kode_barang'],
                'nama_barang' => $row['nama_barang'],
                'satuan' => $row['satuan'],
                'id_kategori' => $row['id_kategori'],
                'nama_kategori' => $row['nama_kategori'],
                'jumlah' => $row['jumlah']
            ];
        }

        return array_values($result);
    }

}
