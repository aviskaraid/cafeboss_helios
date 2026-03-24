<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRNDTable extends Migration
{
public function up(){
        // Category
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'business_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'description'           => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'code'                  => ['type' => 'varchar', 'constraint' => 30,'null' => true],
            'type'                  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'sub_type'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'status'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'sub_status'            => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'employee_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'ref_no'                => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'transaction_date'      => ['type' => 'datetime', 'null' => true],
            'hpp'                   => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'remark'                => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'total'                 => ['type' => 'decimal', 'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'created_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'updated_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_by'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('business_id', 'business', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rnd', true);
    }

    public function down(){
        $this->forge->dropTable('rnd');
    }
}
