<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed auth users first
        $this->call('AuthUserSeeder');
        
        // Then seed teachers
        $this->call('TeachersSeeder');
    }
}
