<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentMethodToOrders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders', [
            'payment_method_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'user_id',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'payment_method_id');
    }
}
