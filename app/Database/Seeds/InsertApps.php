<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertApps extends Seeder
{
    public function run(){
         helper(['url','Becko']);
        $base_url = base_url(); 
        $data = [
            [
                'code'              => becko_code(6,true),
                'activation_code'   => becko_activation_code(13,true),
                'name'              => "ZaxUltimate",
                "developed_by"      => "Fajar Soegi",
                "made_by"           => "Zax Company",
                "made_year"         => "2025",
                "version_number"    => 1,
                "version_name"      => "0.0.1",
                "active"            => 1
            ]
        ];
        $this->db->table('apps')->insertBatch($data);
    }
}
