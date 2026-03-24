<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemSupplierMapTables extends Migration
{
   public function up(){
        // PRODUCT LOCATION TABLE
        $fields = [
            'item_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'supplier_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey(['item_id','supplier_id'],true);
        $this->forge->addForeignKey('item_id', 'items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('supplier_id','supplier', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('item_supplier_map', true);
    }
    public function down(){
        $this->forge->dropTable('item_supplier_map');
    }
}
