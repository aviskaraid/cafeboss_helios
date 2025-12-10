<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosTable extends Migration
{
   public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'business_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'store_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'status'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'shift'                 => ['type' => 'tinyint', 'constraint' => 1, 'default' => 1],
            'open_at'               => ['type' => 'datetime', 'null' => true],
            'opening_amount'        => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'close_at'              => ['type' => 'datetime', 'null' => true],
            'closing_amount'        => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'total_cash'            => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'total_card'            => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'total_transfer'        => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'closing_note'          => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'created_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'updated_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('pos', true);
    }

    public function down(){
        $this->forge->dropTable('pos');
    }
}
