<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosTransactionLinesTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'foodmenu_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'quantity'              => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'price'                 => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'disc'                  => ['type' => 'decimal', 'constraint' => '5,2', 'null' => false,'default'    => 0.00],
            'tax'                   => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'sub_total'             => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'total'                 => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'combo'                 => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'modifiers'             => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted'               => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'promo_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'pos_transactions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('foodmenu_id', 'foodmenu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pos_transactions_lines', true);
    }

    public function down(){
        $this->forge->dropTable('pos_transactions_lines');
    }
}
