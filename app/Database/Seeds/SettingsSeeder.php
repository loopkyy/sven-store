<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['key_name' => 'site_name', 'value' => 'Warung Kita'],
            ['key_name' => 'contact_email', 'value' => 'admin@warungkita.com'],
        ];

        $this->db->table('settings')->insertBatch($data);
    }
}
