<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
  protected $table = 'pembelian';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nama_vendor', 'alamat_vendor', 'nama_pembeli', 'tanggal_pembelian'];
  protected $useTimestamps = true;

  protected $detailModel;
  protected $barangMasukModel;

  public function __construct()
  {
    parent::__construct();
    $this->detailModel = new \App\Models\DetailPembelianModel();
    $this->barangMasukModel = new \App\Models\BarangMasukModel();
  }

  // Update pembelian beserta stok
  public function updatePembelianWithDetail($id, $post)
  {
    // Hapus barang masuk lama (stok otomatis dikurangi)
    $barangMasuk = $this->barangMasukModel->where('id_pembelian', $id)->first();
    if ($barangMasuk) {
      $this->barangMasukModel->deleteBarangMasukWithDetail($barangMasuk['id']);
    }

    // Hapus detail lama
    $this->detailModel->where('id_pembelian', $id)->delete();

    // Update header
    $this->update($id, [
      'nama_vendor' => $post['nama_vendor'],
      'alamat_vendor' => $post['alamat_vendor'],
      'tanggal_pembelian' => $post['tanggal_pembelian'],
      'nama_pembeli' => $post['nama_pembeli']
    ]);

    // Tambah detail baru
    $detailBarang = [];
    foreach ($post['barang_id'] as $i => $barang_id) {
      $jumlah = $post['jumlah'][$i];

      $this->detailModel->insert([
        'id_pembelian' => $id,
        'id_barang' => $barang_id,
        'jumlah' => $jumlah,
        'harga' => $post['harga'][$i]
      ]);

      $detailBarang[] = [
        'id_barang' => $barang_id,
        'jumlah' => $jumlah
      ];
    }

    // Tambah barang masuk baru & update stok
    $this->barangMasukModel->addBarangMasuk($id, $post['tanggal_pembelian'], $detailBarang);
  }

  public function deletePembelianWithStok($id)
  {
    // Hapus barang masuk lama (stok otomatis dikurangi)
    $barangMasuk = $this->barangMasukModel->where('id_pembelian', $id)->first();
    if ($barangMasuk) {
      $this->barangMasukModel->deleteBarangMasukWithDetail($barangMasuk['id']);
    }

    // Hapus detail & header
    $this->detailModel->where('id_pembelian', $id)->delete();
    $this->delete($id);
  }

  public function getAllForIndex()
  {
    $pembelian = $this->db->table('pembelian')
      ->select('pembelian.id, pembelian.nama_vendor, pembelian.alamat_vendor, pembelian.tanggal_pembelian, pembelian.nama_pembeli')
      ->orderBy('pembelian.tanggal_pembelian', 'DESC')
      ->get()
      ->getResultArray();

    // Ambil detail barang untuk setiap pembelian
    foreach ($pembelian as &$p) {
      $p['barang'] = $this->db->table('detail_pembelian')
        ->select('barang.nama_barang, detail_pembelian.jumlah as total_barang, (detail_pembelian.jumlah * detail_pembelian.harga) as total_harga')
        ->join('barang', 'barang.id = detail_pembelian.id_barang')
        ->where('detail_pembelian.id_pembelian', $p['id'])
        ->get()
        ->getResultArray();

      // Hitung total
      $p['total_barang'] = array_sum(array_column($p['barang'], 'total_barang'));
      $p['total_harga'] = array_sum(array_column($p['barang'], 'total_harga'));
    }

    return $pembelian;
  }


  public function getPembelianTerbaru($kategori = null)
  {
    $pembelian = $this->db->table('pembelian')
      ->select('pembelian.id, pembelian.nama_vendor, pembelian.tanggal_pembelian')
      ->orderBy('pembelian.tanggal_pembelian', 'DESC')
      ->get()
      ->getResultArray();

    foreach ($pembelian as &$p) {
      $builder = $this->db->table('detail_pembelian')
        ->select('barang.nama_barang, detail_pembelian.jumlah, kategori.nama AS kategori, barang.satuan')
        ->join('barang', 'barang.id = detail_pembelian.id_barang')
        ->join('kategori', 'kategori.id = barang.kategori_id')
        ->where('detail_pembelian.id_pembelian', $p['id']);

      if ($kategori) {
        $builder->where('kategori.nama', $kategori);
      }

      $p['barang'] = $builder->get()->getResultArray();
    }

    return $pembelian;
  }



}
