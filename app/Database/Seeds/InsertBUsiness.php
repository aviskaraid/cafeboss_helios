<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertBUsiness extends Seeder
{
  public function run(){
        helper(['url','Becko']);
        $businessData = [
            [
                'code'              => becko_business_code(8,true),
                'name'              => "Helios",
                "description"       => "Helios Lounge and Bar",
                "email"             => "helios@email.com",
                "address"           => "Pantai Indah Kapuk",
                "phone"             => "085721983912",
                "active"            => 1
            ]
        ];
        $this->db->table('business')->insertBatch($businessData);
        $getID = $this->db->insertID();
        $businessSetup = [
            [
                'business_id'           => $getID,
                'display_name'          => "Helios Lounge & BAR",
                "active"                => 1,
                "start_date"            =>date("Y-m-d H:i:s")
            ]
        ];
        $this->db->table('business_setup')->insertBatch($businessSetup);

    }
}
