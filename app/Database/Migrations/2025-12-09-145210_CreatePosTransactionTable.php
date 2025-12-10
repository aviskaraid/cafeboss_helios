<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosTransactionTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pos_id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'type'                  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'sub_type'              => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'payment_method'        => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'table_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'sequence'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'transaction_date'      => ['type' => 'datetime', 'null' => true],
            'ref_no'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'disc_type'             => ['type' => 'enum', 'constraint' => ['fixed', 'percentage'], 'null' => true, 'default'=> 'fixed'],
            'disc_amount'           => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'tax_id'                => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'tax_amount'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'updated_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pos_id', 'pos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pos_transactions', true);
    }

    public function down(){
        $this->forge->dropTable('pos_transactions');
    }
}
