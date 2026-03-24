<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosTransactionPaymentsTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'business_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'is_return'             => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'amount'                => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default' => 0.00],
            'method'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'payment_type'          => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'transaction_number'        => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'card_number'           => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'card_type'             => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'card_holder_name'      => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'card_month'            => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'card_year'             => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'card_sequrity'         => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'cheque_number'         => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'bank_account_number'   => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'bank_account_name'   => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'note'                  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'document'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'payment_ref_no'        => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'paid_on'               => ['type' => 'datetime', 'null' => true],
            'created_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => false, 'default' => 0],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'updated_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'pos_transactions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('business_id', 'business', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pos_transactions_payments', ifNotExists: true);
    }

    public function down(){
        $this->forge->dropTable('pos_transactions_payments');
    }
}
