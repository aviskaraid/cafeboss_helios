<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertCustomer extends Seeder
{
    public function run(){
        helper(['url','Becko']);
        $businessData = [
            [
                'code'              => becko_customer_code(8,true),
                'username'          => "general",
                "fullname"          => "general member",
                "email"             => "customer@email.com",
                "address"           => "NN",
                "phone_number"             => "00000",
                "active"            => 1
            ]
        ];
        $this->db->table('customers')->insertBatch($businessData);
    }
}
