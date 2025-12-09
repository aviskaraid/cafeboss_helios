<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMainModuleTables extends Migration
{
      public function up(){
        // Groups Permission Pivot Table
        $fields = [
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'              => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'icon_image'        => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'order_number'             => ['type' => 'int', 'constraint' => 11, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id',true);
        $this->forge->createTable('main_menu', true);
    }
    public function down(){
        $this->forge->dropTable("main_menu");
    }
}
