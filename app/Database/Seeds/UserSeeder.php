<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
   public function run()
{
    $data = [
        [
            'name'     => 'Pemilik Toko',
            'username' => 'superadmin',
            'password' => password_hash('super123', PASSWORD_DEFAULT),
            'role'     => 'superadmin',
            'is_active' => 1,
        ],
        [
            'name'     => 'Admin Gudang',
            'username' => 'admin1',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin',
            'is_active' => 1,
        ]
    ];

    $this->db->table('users')->insertBatch($data);
}

}
