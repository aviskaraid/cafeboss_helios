<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseRequestTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'request_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'transaction_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'transaction_date'      => ['type' => 'datetime', 'null' => true],
            'ref_no'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
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
        $this->forge->createTable('purchase_request', true);
    }

    public function down(){
        $this->forge->dropTable('purchase_request');
    }
}
