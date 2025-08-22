<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPembelian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pembelian' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_barang' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah' => ['type' => 'INT', 'null' => false],
            'harga' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pembelian', 'pembelian', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_barang', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_pembelian');
    }

    public function down()
    {
        $this->forge->dropTable('detail_pembelian');
    }
}
