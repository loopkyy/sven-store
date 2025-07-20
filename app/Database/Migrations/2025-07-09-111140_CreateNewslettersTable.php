<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewslettersTable extends Migration
{
   public function up()
{
    $this->forge->addField([
        'id'         => ['type' => 'INT', 'auto_increment' => true],
        'email'      => ['type' => 'VARCHAR', 'constraint' => 100],
        'subscribed' => ['type' => 'TINYINT', 'default' => 1], // 1 = aktif
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('newsletters');
}

    public function down()
    {
        //
    }
}
