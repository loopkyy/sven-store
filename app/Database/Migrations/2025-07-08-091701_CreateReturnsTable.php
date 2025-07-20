<?php

namespace App\Database\Migrations;

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReturnsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'order_id'     => ['type' => 'INT'],
            'reason'       => ['type' => 'TEXT', 'null' => false],
            'status'       => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('returns');
    }

    public function down()
    {
        $this->forge->dropTable('returns');
    }
}
