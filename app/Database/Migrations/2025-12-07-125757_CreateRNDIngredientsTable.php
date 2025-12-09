<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRNDIngredientsTable extends Migration
{
    public function up(){
        // Variations Table
        $this->forge->addField([
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item_id'                   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'consumption'               => ['type' => 'decimal',  'constraint' => '10,2', 'null' => false,'default'    => 0.00],
            'cost'                      => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'total'                     => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'rnd_id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'active'                    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'updated_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_by'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('item_id', 'items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('rnd_id', 'rnd', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rnd_ingredient', true);
    }

    public function down()
    {
        $this->forge->dropTable('rnd_ingredient');
    }
}
