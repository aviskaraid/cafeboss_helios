<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseGoodReceiveTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'po_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'supplier_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'transaction_date'      => ['type' => 'datetime', 'null' => true],
            'ref_no'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'status'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'received_by'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('purchase_good_receive', true);
    }

    public function down(){
        $this->forge->dropTable('purchase_good_receive', true);
    }
}
