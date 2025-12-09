<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemLocationTable extends Migration
{
    public function up(){
        // PRODUCT LOCATION TABLE
        $fields = [
            'item_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'warehouse_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey(['item_id','warehouse_id'],true);
        $this->forge->addForeignKey('item_id', 'items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('warehouse_id','warehouse', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('item_location', true);
    }
    public function down(){
        $this->forge->dropTable('item_location');
    }
}
