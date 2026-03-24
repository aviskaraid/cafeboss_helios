<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessTable extends Migration
{
   public function up(){
        // Business Table
        $this->forge->addField([
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code'                      => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'name'                      => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'description'               => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'email'                     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'address'                   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'phone'                     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'created_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'updated_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('name', false,true);
        $this->forge->createTable('business', true);
    }
    public function down(){
        $this->forge->dropTable('business');
    }
}
