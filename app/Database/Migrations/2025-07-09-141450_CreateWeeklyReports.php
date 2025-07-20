<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWeeklyReports extends Migration
{
  public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'start_date' => [
            'type' => 'DATE',
        ],
        'end_date' => [
            'type' => 'DATE',
        ],
        'total_order' => [
            'type' => 'INT',
            'default' => 0,
        ],
        'total_pendapatan' => [
            'type' => 'DECIMAL',
            'constraint' => '15,2',
            'default' => 0.00,
        ],
        'pelanggan_baru' => [
            'type' => 'INT',
            'default' => 0,
        ],
        'top_products' => [
            'type' => 'TEXT', // format JSON
            'null' => true,
        ],
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
    $this->forge->createTable('weekly_reports');
}

public function down()
{
    $this->forge->dropTable('weekly_reports');
}

}
