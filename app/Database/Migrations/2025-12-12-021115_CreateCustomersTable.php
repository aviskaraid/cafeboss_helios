<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersTable extends Migration
{
   public function up(){  
        // Table Users
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => 0, 'default' => 0],
            'code'                  => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'email'                 => ['type' => 'varchar', 'constraint' => 255],
            'username'              => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'fullname'              => ['type' => 'varchar', 'constraint' => 100, 'null'=>true],
            'address'               => ['type' => 'varchar', 'constraint' => 100, 'null'=>true],
            'phone_number'          => ['type' => 'varchar', 'constraint' => 20, 'null'=>true],
            'picture'               => ['type' => 'BLOB', 'null' => true],
            'date_of_birth'         => ['type' => 'date', 'null' => true],
            'date_of_anniversary'   => ['type' => 'date', 'null' => true],
            'status'                => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'level'                 => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'group_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => 0, 'default' => 0],
            'location_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => 0, 'default' => 0],
            'default_disc'          => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'active'                => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'force_pass_reset'      => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'updated_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customers', true);
    }
    public function down()
    {
        $this->forge->dropTable('customers');
    }
}
