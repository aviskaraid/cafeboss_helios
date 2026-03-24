<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableFoodMenuIngredientTable extends Migration
{
    public function up(){
        // Variations Table
        $this->forge->addField([
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item_id'                   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'consumption'               => ['type' => 'decimal',  'constraint' => '10,2', 'null' => false,'default'    => 0.00],
            'cost'                      => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'total'                     => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'foodmenu_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'active'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'updated_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('item_id', 'items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('foodmenu_id', 'foodmenu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('foodmenu_ingredient', true);
    }

    public function down()
    {
        $this->forge->dropTable('foodmenu_ingredient');
    }
}
