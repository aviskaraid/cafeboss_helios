<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccessTables extends Migration
{
    public function up(){
        // TABLE USER GROUPS
        $this->forge->addField([
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'module_name'               => ['type' => 'varchar', 'constraint' => 100],
            'function_name'             => ['type' => 'varchar', 'constraint' => 100],
            'label_name'                => ['type' => 'varchar', 'constraint' => 100],
            'parent_id'                 => ['type' => 'int', 'constraint' => 11,'unsigned' => true, 'default' => 0],
            'main_module_id'            => ['type' => 'int', 'constraint' => 11,'unsigned' => true, 'default' => 0],
            'url'                       => ['type' => 'varchar', 'constraint' => 100, 'default' => null],
            'active'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'icon_image'                => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'created_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'updated_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('access', true);
    }
    public function down(){
        $this->forge->dropTable('access');
    }
}
