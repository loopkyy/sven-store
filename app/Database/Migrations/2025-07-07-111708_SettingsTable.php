<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'auto_increment' => true],
            'key_name'  => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'value'     => ['type' => 'TEXT', 'null' => true],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
            'updated_at'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
