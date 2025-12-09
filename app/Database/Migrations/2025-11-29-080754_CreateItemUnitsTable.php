<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemUnitsTable extends Migration
{
    public function up(){
        // Groups Permission Pivot Table
        $fields = [
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'unit_source'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'unit_dest'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'value_source'      => ['type' => 'decimal', 'constraint' => '10,2', 'null' => false, 'default' => 0.00],
            'value_dest'        => ['type' => 'decimal', 'constraint' => '10,2', 'null' => false, 'default' => 0.00],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id',true);
        $this->forge->createTable('item_units', true);
    }
    public function down(){
        $this->forge->dropTable("item_units");
    }
}
