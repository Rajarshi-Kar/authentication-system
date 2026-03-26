<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'HAWK - Full Stack Auth API',
            'message' => 'API is running successfully!'
        ];

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Welcome to HAWK API',
            'version' => '1.0',
            'endpoints' => [
                'register' => 'POST /api/auth/register',
                'login' => 'POST /api/auth/login',
                'profile' => 'GET /api/profile (requires token)',
                'teachers' => 'GET /api/teachers (requires token)'
            ]
        ]);
    }
}
