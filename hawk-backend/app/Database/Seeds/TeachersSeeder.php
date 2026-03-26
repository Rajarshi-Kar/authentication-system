<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeachersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'university_name' => 'KIIT University',
                'gender' => 'Male',
                'year_joined' => 2018,
                'specialization' => 'Computer Science',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'university_name' => 'Delhi University',
                'gender' => 'Female',
                'year_joined' => 2019,
                'specialization' => 'Information Technology',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 3,
                'university_name' => 'Mumbai University',
                'gender' => 'Male',
                'year_joined' => 2020,
                'specialization' => 'Electronics Engineering',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('teachers')->insertBatch($data);
    }
}
