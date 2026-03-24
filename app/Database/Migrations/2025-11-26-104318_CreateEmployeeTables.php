<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeTables extends Migration
{
    public function up(){
        // TABLE USER GROUPS
        $this->forge->addField([
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code'                      => ['type' => 'varchar', 'constraint' => 30,'null'=>true],
            'first_name'                => ['type' => 'varchar', 'constraint' => 100,'null'=>true],
            'last_name'                 => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'department_id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'group_id'                  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'address'                   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'city'                      => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'state'                     => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'zip'                       => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'picture'                   => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'active'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'updated_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('department_id', 'departments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('group_id', 'employee_groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employees', true);
    }
    public function down(){
        $this->forge->dropTable('employees');
    }
}
