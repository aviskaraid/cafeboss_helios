<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseOrderTable extends Migration
{
    public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'stockrequest_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'purchaserequest_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'transaction_date'      => ['type' => 'datetime', 'null' => true],
            'type'                  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'ref_no'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'remark'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'supplier_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'department_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'company_code'          => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'line_item_number'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'ship_to'               => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'bill_to'               => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
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
        $this->forge->createTable('purchase_order', true);
    }

    public function down(){
        $this->forge->dropTable('purchase_order');
    }
}
