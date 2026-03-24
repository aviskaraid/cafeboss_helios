<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockCardTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'date'              => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'item_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'stock_in'          => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'stock_out'         => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'stock_on_hand'     => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'remark'            => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'transaction_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'warehouse_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('stock_card', true);
    }

    public function down(){
        $this->forge->dropTable('stock_card');
    }
}
