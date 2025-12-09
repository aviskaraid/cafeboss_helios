<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoreSettings extends Migration
{
    public function up(){
        // Business Table
        $this->forge->addField([
            'id'                            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'store_id'                      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true,'default' => 0],
            'display_name'                  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'logo'                          => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'dp'                            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'minimum_charge'                => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            "vat"                           => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],           
            'lock_close'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'split_bill'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'merge_bill'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'void'                          => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'take_away'                     => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'active'                        => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_by'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                    => ['type' => 'datetime', 'null' => true],
            'updated_at'                    => ['type' => 'datetime', 'null' => true],
            'updated_by'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                    => ['type' => 'datetime', 'null' => true],
            'deleted_by'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('store_id', 'stores', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('store_setup', true);
    }
    public function down(){
        $this->forge->dropTable('store_setup');
    }
}
