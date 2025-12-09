<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSessionTables extends Migration
{
    public function up(){
        $this->forge->addField([
            'id'            => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => false],
            'ip_address'    => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => false],
            'timestamp'     => ['type' => 'TIMESTAMP', 'null' => false, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'data'          => ['type' => 'BLOB', 'null' => false],
        ]);
        $this->forge->addKey('id', primary: true);
        $this->forge->addKey('timestamp');
        $this->forge->createTable('sessions'); // Use the same name as $sessionSavePath
    }
    public function down(){
        $this->forge->dropTable('sessions');
    }
}
