<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Ambil semua role
        $roles = $this->db->table('role')->get()->getResultArray();

        $data = [];

        // Admin
        $adminRoleId = array_column($roles, 'id', 'name')['admin'] ?? 1;
        $data[] = [
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'role_id' => $adminRoleId,
            'foto' => NULL,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('user')->insertBatch($data);
    }
}
