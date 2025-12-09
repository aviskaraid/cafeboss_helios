<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertUser extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email'         => "admin@virtualzax.com",
                'designation'   => "superadmin",
                'username'      => "admin",
                "fullname"      => "Administrator",
                "active"        => 1,
                "password_hash" =>  password_hash("admin123", PASSWORD_DEFAULT)
            ]
        ];
        $data2 = [
            [
                'group_id'         => 1,
                'user_id'      => 1
            ]
        ];
        $this->db->table('users')->insertBatch($data);
        $this->db->table('user_groups_users')->insertBatch($data2);
    }
}
