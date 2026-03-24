<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserEmployeesTable extends Migration
{
   public function up(){
        // Groups Permission Pivot Table
        $fields = [
            'employee_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['employee_id', 'user_id'],true);
        $this->forge->addForeignKey('employee_id', 'employees', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('user_employees', true);
    }
    public function down(){
        $this->forge->dropTable("user_employees");
    }
}
