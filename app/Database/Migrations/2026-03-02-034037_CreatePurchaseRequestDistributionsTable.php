<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseRequestDistributionsTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pr_lines_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'cost_center'           => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'ref_no'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'amount'                => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'status'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'user_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
         $this->forge->addForeignKey('pr_lines_id', 'purchase_request_lines', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('purchase_distributions', true);
    }

    public function down(){
        $this->forge->dropTable('purchase_distributions');
    }
}
