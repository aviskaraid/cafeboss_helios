<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertGroups extends Seeder
{
    public function run(){
       $data = [
                [
                    "name"          => "administrator",
                    "description"   => "Administrator",
                    "active"        => 1,
                    "created_at"    => date("Y-m-d H:i:s"),
                    "updated_at"    => date("Y-m-d H:i:s")
                ]                
            ];
        $this->db->table('user_groups')->insertBatch($data);
    }
}
