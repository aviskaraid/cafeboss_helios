<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseRequestLinesTable extends Migration
{
public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'item_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'quantity'              => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'purchase_request', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('purchase_request_lines', true);
    }

    public function down(){
        $this->forge->dropTable('purchase_request_lines');
    }
}
