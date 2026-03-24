<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertMainMenu extends Seeder
{
    public function run(){
       $data = [
                [
                    "name"          => "Dashboard",
                    "active"        => 1,
                    "created_at"    => date("Y-m-d H:i:s"),
                    "updated_at"    => date("Y-m-d H:i:s")
                ],
                [
                    "name"          => "Master",
                    "active"        => 1,
                    "created_at"    => date("Y-m-d H:i:s"),
                    "updated_at"    => date("Y-m-d H:i:s")
                ]    
            ];
        $this->db->table('main_menu')->insertBatch($data);
    }
}
