<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'john@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'jane@example.com',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'robert@example.com',
                'first_name' => 'Robert',
                'last_name' => 'Johnson',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('auth_user')->insertBatch($data);
    }
}
