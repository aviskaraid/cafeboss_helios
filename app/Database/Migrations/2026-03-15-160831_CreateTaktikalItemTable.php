<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaktikalItemTable extends Migration
{
   public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'min_qty'              => ['type' => 'decimal', 'constraint' => '12,2', 'null' => false,'default'    => 0.00],
            'max_qty'              => ['type' => 'decimal', 'constraint' => '12,2', 'null' => false,'default'    => 0.00],
            'reward_disc'          => ['type' => 'decimal', 'constraint' => '2,2', 'null' => false,'default'    => 0.00],
            'reward_amount'          => ['type' => 'decimal', 'constraint' => '15,2', 'null' => false,'default'    => 0.00],
            'remark'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'active'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'comments'                => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'taktikal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('taktikal_item', true);
    }

    public function down(){
        $this->forge->dropTable('taktikal_item');
    }
}
