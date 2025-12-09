<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
  public function up(){  
        // Table Users
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code'             => ['type' => 'varchar', 'constraint' => 30],
            'email'             => ['type' => 'varchar', 'constraint' => 255],
            'username'          => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'fullname'          => ['type' => 'varchar', 'constraint' => 100],
            'designation'       => ['type' => 'varchar', 'constraint' => 100],
            'password_hash'     => ['type' => 'varchar', 'constraint' => 255],
            'reset_hash'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'reset_at'          => ['type' => 'datetime', 'null' => true],
            'reset_expires'     => ['type' => 'datetime', 'null' => true],
            'picture'           => ['type' => 'BLOB', 'null' => true],
            'activate_hash'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status'            => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'force_pass_reset'  => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'deleted'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);
    }
    public function down()
    {
        $this->forge->dropTable('users');
    }
}
