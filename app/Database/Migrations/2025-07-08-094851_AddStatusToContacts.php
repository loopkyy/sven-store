<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToContacts extends Migration
{
   public function up()
{
    $this->forge->addColumn('contacts', [
        'status' => [
            'type'       => 'ENUM',
            'constraint' => ['new', 'read', 'replied'],
            'default'    => 'new',
            'after'      => 'message'
        ],
    ]);
}

public function down()
{
    $this->forge->dropColumn('contacts', 'status');
}

}
