<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFoodMenuTable extends Migration
{
    public function up()
    {
        // Category
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'business_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'code'              => ['type' => 'varchar', 'constraint' => 30,'null' => true],
            'name'              => ['type' => 'varchar', 'constraint' => 100,'null' => true],
            'display_name'      => ['type' => 'varchar', 'constraint' => 100,'null' => true],
            'description'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'category_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'type_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => false, 'default' => 0],
            'as_combo'          => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'as_modifiers'      => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'as_variants'       => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'premade'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'tax_information'   => ['type' => 'TEXT', 'null' => true],
            'tax'               => ['type' => 'varchar', 'constraint' => 50,  'null' => true],
            'enable_stock'      => ['type' => 'tinyint', 'constraint' => 1, 'null'=>0, 'default' => 1],
            'expired_date'      => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'expire_period'     => ['type' => 'decimal',  'constraint' => '10,2', 'null' => false,'default'    => 0.00],
            'alert_qty'         => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'weight'            => ['type' => 'decimal',  'constraint' => '5,2', 'null' => false,'default'    => 0.00],
            'dimension'         => ['type' => 'varchar',  'constraint' => 255, 'null' => false],
            'picture'           => ['type' => 'BLOB', 'null' => true],
            'purchase_price'    => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'hpp'               => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'sell_price'        => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'service_price'     => ['type' => 'decimal',  'constraint' => '22,2', 'null' => false,'default'    => 0.00],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('code',false,true);
        $this->forge->createTable('foodmenu', true);
    }
    public function down(){
        $this->forge->dropTable('foodmenu');
    }
}
