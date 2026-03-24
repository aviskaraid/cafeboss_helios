<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserGroupsUserstable extends Migration
{
    public function up(){
        // Groups Permission Pivot Table
        $fields = [
            'group_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['group_id', 'user_id'],true);
        $this->forge->addForeignKey('group_id', 'user_groups', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('user_groups_users', true);
    }
    public function down(){
        $this->forge->dropTable("user_groups_users");
    }
}
