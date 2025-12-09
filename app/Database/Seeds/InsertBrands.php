<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertBrands extends Seeder
{
    public function run(){
        helper(['url','Becko']);
        $data = [
            [
                'name'              => "umum",
                "description"       => "Brands Umum",
                "active"            => 1
            ]
        ];
        $this->db->table('brands')->insertBatch($data);
    }
}
