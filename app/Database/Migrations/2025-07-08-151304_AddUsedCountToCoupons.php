<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsedCountToCoupons extends Migration
{
 public function up()
{
    $this->forge->addColumn('coupons', [
        'used_count' => [
            'type'       => 'INT',
            'constraint' => 5,
            'default'    => 0,
            'after'      => 'max_uses' // atau sesuaikan urutan sesuai kebutuhan
        ],
    ]);
}

public function down()
{
    $this->forge->dropColumn('coupons', 'used_count');
}

}
