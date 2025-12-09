<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAreaTable extends Migration
{
     public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'business_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'store_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'name'                  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'description'           => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'location'              => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'smoking'               => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'ac'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'meeting'               => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'spesification'         => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'open_at'               => ['type' => 'TIME', 'null' => true],
            'close_at'              => ['type' => 'TIME', 'null' => true],
            'created_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'updated_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('pos_table_area', true);
    }

    public function down(){
        $this->forge->dropTable('pos_table_area');
    }
}
