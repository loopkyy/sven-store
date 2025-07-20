<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMaxUsesToCoupons extends Migration
{
 public function up()
{
    $this->forge->addColumn('coupons', [
        'max_uses' => [
            'type'       => 'INT',
            'constraint' => 5,
            'default'    => 0,
            'after'      => 'value'
        ],
    ]);
}

    public function down()
{
    $this->forge->dropColumn('coupons', 'max_uses');
}

}
