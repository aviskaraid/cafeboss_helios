<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFoodMenuCategoryMapTable extends Migration
{
   public function up(){
        // PRODUCT LOCATION TABLE
        $fields = [
            'foodmenu_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'category_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey(['foodmenu_id','category_id'],true);
        $this->forge->addForeignKey('foodmenu_id', 'foodmenu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id','foodmenu_category', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('foodmenu_category_map', true);
    }
    public function down(){
        $this->forge->dropTable('foodmenu_category_map');
    }
}
