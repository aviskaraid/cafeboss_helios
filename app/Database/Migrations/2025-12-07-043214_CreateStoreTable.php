<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoreTable extends Migration
{
    public function up(){
        // Branch Table
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'business_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'code'              => ['type' => 'varchar', 'constraint' => 30,'null' => true],
            'name'              => ['type' => 'varchar', 'constraint' => 100],
            'description'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'address'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'phone_number'      => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'location'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'remark'            => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'type'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => false, 'default' => 0],
            'picture'           => ['type' => 'BLOB', 'null' => true],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->addForeignKey('business_id', 'business', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stores', true);
    }
    public function down(){
        $this->forge->dropTable('stores');
    }
}
