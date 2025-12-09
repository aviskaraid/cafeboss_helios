<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoreCategoryMap extends Migration
{
    public function up(){
        // PRODUCT LOCATION TABLE
        $fields = [
            'store_id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'category_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey(['store_id','category_id'],true);
        $this->forge->addForeignKey('store_id', 'stores', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id','foodmenu_category', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('store_category_map', true);
    }
    public function down(){
        $this->forge->dropTable('store_category_map');
    }
}
