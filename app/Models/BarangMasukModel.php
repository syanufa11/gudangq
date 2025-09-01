<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pembelian', 'tanggal_masuk'];
    protected $useTimestamps = true;

    protected $detailModel;
    protected $barangModel;

    public function __construct()
    {
        parent::__construct();
        $this->detailModel = new \App\Models\DetailBarangMasukModel();
        $this->barangModel = new \App\Models\BarangModel();
    }

    /**
     * Tambah barang masuk + update stok
     */
    public function addBarangMasuk($idPembelian, $tanggalMasuk, $detailBarang)
    {
        $idBarangMasuk = $this->insert([
            'id_pembelian' => $idPembelian,
            'tanggal_masuk' => $tanggalMasuk
        ], true);

        foreach ($detailBarang as $item) {
            $this->detailModel->insert([
                'id_barang_masuk' => $idBarangMasuk,
                'id_barang' => $item['id_barang'],
                'jumlah' => $item['jumlah']
            ]);

            $this->barangModel->adjustStok($item['id_barang'], $item['jumlah'], 'tambah');
        }
    }

    /**
     * Hapus barang masuk beserta detail & update stok
     */
    public function deleteBarangMasukWithDetail($idBarangMasuk)
    {
        $details = $this->detailModel->where('id_barang_masuk', $idBarangMasuk)->findAll();

        foreach ($details as $item) {
            $this->barangModel->adjustStok($item['id_barang'], $item['jumlah'], 'kurang');
        }

        $this->detailModel->where('id_barang_masuk', $idBarangMasuk)->delete();
        $this->delete($idBarangMasuk);
    }

    /**
     * Base query untuk join semua tabel
     */
    private function baseQuery()
    {
        return $this->db->table('barang_masuk')
            ->select('
                barang_masuk.id,
                barang_masuk.tanggal_masuk,
                pembelian.id AS id_pembelian,
                pembelian.nama_vendor,
                pembelian.alamat_vendor,
                pembelian.tanggal_pembelian,
                pembelian.nama_pembeli,
                detail_barang_masuk.id AS id_detail,
                detail_barang_masuk.id_barang_masuk,
                detail_barang_masuk.id_barang_masuk,
                detail_barang_masuk.jumlah,
                barang.id AS id_barang,
                barang.nama_barang,
                barang.kode_barang,
                barang.satuan,
                barang.jumlah_stok,
                kategori.id AS id_kategori,
                kategori.nama AS nama_kategori
            ')
            ->join('pembelian', 'pembelian.id = barang_masuk.id_pembelian', 'left')
            ->join('detail_barang_masuk', 'detail_barang_masuk.id_barang_masuk = barang_masuk.id', 'left')
            ->join('barang', 'barang.id = detail_barang_masuk.id_barang', 'left')
            ->join('kategori', 'kategori.id = barang.kategori_id', 'left')
            ->orderBy('barang_masuk.id', 'DESC'); // DESCENDING
    }

    /**
     * Ambil transaksi barang masuk lengkap, grouped per transaksi
     */
    public function getBarangMasukDetail($dari = null, $sampai = null)
    {
        $builder = $this->baseQuery();

        if ($dari && $sampai) {
            $builder->where('barang_masuk.tanggal_masuk >=', $dari)
                ->where('barang_masuk.tanggal_masuk <=', $sampai);
        }

        $rows = $builder->get()->getResultArray();
        $result = [];

        foreach ($rows as $row) {
            $id = $row['id'];
            if (!isset($result[$id])) {
                $result[$id] = [
                    'id' => $row['id'],
                    'tanggal_masuk' => $row['tanggal_masuk'],
                    'id_pembelian' => $row['id_pembelian'],
                    'nama_vendor' => $row['nama_vendor'],
                    'alamat_vendor' => $row['alamat_vendor'],
                    'tanggal_pembelian' => $row['tanggal_pembelian'],
                    'nama_pembeli' => $row['nama_pembeli'],
                    'detail' => []
                ];
            }

            $result[$id]['detail'][] = [
                'id_detail' => $row['id_detail'],
                'id_barang' => $row['id_barang'],
                'nama_barang' => $row['nama_barang'],
                'kode_barang' => $row['kode_barang'],
                'satuan' => $row['satuan'],
                'jumlah_stok' => $row['jumlah_stok'],
                'jumlah' => $row['jumlah'],
                'id_kategori' => $row['id_kategori'],
                'nama_kategori' => $row['nama_kategori']
            ];
        }

        return array_values($result);
    }

    /**
     * Ambil detail lengkap per transaksi tertentu
     */
    public function withDetail($id)
    {
        $data = $this->baseQuery()->where('barang_masuk.id', $id)->get()->getResultArray();

        if (empty($data))
            return null;

        $total_barang = array_sum(array_column($data, 'jumlah'));

        return [
            'barangMasuk' => $data[0],
            'detail' => $data,
            'total_barang' => $total_barang
        ];
    }
}
