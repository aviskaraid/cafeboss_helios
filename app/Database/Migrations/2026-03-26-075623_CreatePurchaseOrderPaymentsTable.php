<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseOrderPaymentsTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'transaction_date'      => ['type' => 'datetime', 'null' => true],
            'type'                  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'amount'                => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'changes'               => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'status'                => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'created_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'updated_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('purchase_payments', true);
    }

    public function down(){
        $this->forge->dropTable('purchase_payments', true);
    }
}
