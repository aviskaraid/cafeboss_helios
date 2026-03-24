<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessSetupTable extends Migration
{
    public function up(){
        // Business Table
        $this->forge->addField([
            'id'                            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'business_id'                   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true,'default' => 0],
            'display_name'                  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'logo'                          => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'po_prefixes'                   => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'prod_prefixes'                 => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'expense_prefixes'              => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'sales_prefixes'                => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'stores_prefixes'               => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'adjust_stock_prefixes'         => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'customers_prefixes'            => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'suppliers_prefixes'            => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'user_prefixes'                 => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'profit_percent_default'        => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'retur_po_prefixes'             => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'retur_sales_prefixes'          => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'payment_sales_prefixes'        => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'payment_po_prefixes'           => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'payment_expense_prefixes'      => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'active'                        => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'start_date'                    => ['type' => 'date', 'null' => true],
            'created_by'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                    => ['type' => 'datetime', 'null' => true],
            'updated_at'                    => ['type' => 'datetime', 'null' => true],
            'updated_by'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                    => ['type' => 'datetime', 'null' => true],
            'deleted_by'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('business_id', 'business', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('business_setup', true);
    }
    public function down(){
        $this->forge->dropTable('business_setup');
    }
}
