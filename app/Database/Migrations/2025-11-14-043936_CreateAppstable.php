<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppstable extends Migration
{
     public function up()
    {
        // APPS TABLE
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code'              => ['type' => 'varchar', 'constraint' => 6],
            'activation_code'   => ['type' => 'varchar', 'constraint' => 100],
            'name'              => ['type' => 'varchar', 'constraint' => 30],
            'description'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'img_thumbnails'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'img_profile'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'website'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'url'               => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'access_api'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'developed_by'      => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'made_by'           => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'made_year'         => ['type' => 'varchar', 'constraint' => 4, 'null' => true],
            'version_number'    => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'version_name'      => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'access_code'       => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'access_hash'       => ['type' => 'varchar', 'constraint' => 255],
            'access_expired'    => ['type' => 'datetime', 'null' => true],
            'access_activate'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'access_email'      => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'server_url'        => ['type' => 'varchar', 'constraint' => 120, 'null' => true],
            'created_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'updated_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_by'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['name','code','activation_code'],false,true); 
        $this->forge->createTable('apps', true);
    }
    public function down(){
        //
        $this->forge->dropTable('apps');
    }
}
