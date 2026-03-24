<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupAcessTable extends Migration
{
    public function up(){
        // Groups Permission Pivot Table
        $fields = [
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'group_id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'access_parent_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'access_child_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id',true);
        $this->forge->createTable('groups_access', true);
    }
    public function down(){
        $this->forge->dropTable("groups_access");
    }
}
