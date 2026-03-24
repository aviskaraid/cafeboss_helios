<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaktikalTable extends Migration
{
    public function up(){
        // Variations Table
        $this->forge->addField([
            'id'                       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ref_no'                   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'supplier_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'description'              => ['type' => 'varchar', 'constraint' => 150, 'null' => true],
            'detail'                   => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'status'                    => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'start_time'                => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'end_time'                  => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'active'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'updated_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('taktikal', true);
    }

    public function down()
    {
        $this->forge->dropTable('taktikal');
    }
}
