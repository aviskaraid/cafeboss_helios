<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseGoodReceiveLinesTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'item_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'po_line_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'quantity_order'        => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'quantity_received'     => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'unit'                  => ['type' => 'int', 'constraint' => 11, 'unsigned' => false, 'default' => 0],
            'remark'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'delivery_date'         => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'comments'              => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'warehouse_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'purchase_good_receive', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('purchase_good_receive_lines', true);
    }

    public function down(){
        $this->forge->dropTable('purchase_good_receive_lines');
    }
}
