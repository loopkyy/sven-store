<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNameToUsers extends Migration
{
public function up()
{
    $this->forge->addColumn('users', [
        'name' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
            'after' => 'id', // atau letakkan setelah username
            'null' => true,
        ],
    ]);
}

public function down()
{
    $this->forge->dropColumn('users', 'name');
}

}
