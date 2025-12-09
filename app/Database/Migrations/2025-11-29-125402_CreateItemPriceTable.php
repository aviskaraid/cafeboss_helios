<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemPriceTable extends Migration
{
    public function up(){
        // Variations Table
        $this->forge->addField([
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item_id'                   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'purchase_price'            => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'purchase_price_tax'        => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'hpp'                       => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'sell_price'                => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'sell_price_tax'            => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'profit_percent'            => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'warehouse_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
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
        $this->forge->addForeignKey('warehouse_id', 'warehouse', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('item_price', true);
    }

    public function down()
    {
        $this->forge->dropTable('item_price');
    }
}
