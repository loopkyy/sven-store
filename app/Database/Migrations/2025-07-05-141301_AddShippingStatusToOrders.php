<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddShippingStatusToOrders extends Migration
{
    public function up()
{
    $this->forge->addColumn('orders', [
        'shipping_status' => [
            'type' => 'VARCHAR',
            'constraint' => 50,
            'default' => 'belum dikirim', // bisa: belum dikirim, dikirim, diterima
            'after' => 'status'
        ],
    ]);
}

public function down()
{
    $this->forge->dropColumn('orders', 'shipping_status');
}

}

