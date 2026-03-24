<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DbSeeder extends Seeder
{
    public function run()
    {
         $this->call(InsertApps::class);
         $this->call(InsertGroups::class);
         $this->call(InsertUser::class);
         $this->call(InsertMainMenu::class);
         
    }
}
