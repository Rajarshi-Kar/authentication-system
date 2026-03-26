<?php

namespace App\Controllers;

use App\Models\AuthUserModel;
use App\Models\TeachersModel;

class AuthController extends BaseController
{
    protected $authUserModel;
    protected $teachersModel;

    public function __construct()
    {
        $this->authUserModel = new AuthUserModel();
        $this->teachersModel = new TeachersModel();
    }

    /**
     * Register a new user
     * Expects: email, first_name, last_name, password, university_name, gender, year_joined
     */
    public function register()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'status' => false,
                'message' => 'Method not allowed'
            ]);
        }

        $data = $this->request->getJSON(true);

        // Validate required fields
        $errors = $this->validateRegistration($data);
        if (!empty($errors)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ]);
        }

        try {
            // Check if email already exists
            if ($this->authUserModel->where('email', $data['email'])->first()) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status' => false,
                    'message' => 'Email already registered'
                ]);
            }

            // Hash the password
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

            // Insert auth user
            $userId = $this->authUserModel->insert([
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'password' => $data['password'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if (!$userId) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => false,
                    'message' => 'Failed to create user'
                ]);
            }

            // Insert teacher data
            $this->teachersModel->insert([
                'user_id' => $userId,
                'university_name' => $data['university_name'],
                'gender' => $data['gender'],
                'year_joined' => $data['year_joined'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Generate JWT token
            $token = $this->generateJWT($userId, $data['email']);

            return $this->response->setStatusCode(201)->setJSON([
                'status' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user_id' => $userId,
                    'email' => $data['email'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'token' => $token
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Login user
     * Expects: email, password
     */
    public function login()
    {
        $this->response->setHeader('Content-Type', 'application/json');

        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'status' => false,
                'message' => 'Method not allowed'
            ]);
        }

        $data = $this->request->getJSON(true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'message' => 'Email and password are required'
            ]);
        }

        try {
            // Find user by email
            $user = $this->authUserModel->where('email', $data['email'])->first();

            if (!$user) {
                return $this->response->setStatusCode(401)->setJSON([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ]);
            }

            // Verify password
            if (!password_verify($data['password'], $user['password'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ]);
            }

            // Generate JWT token
            $token = $this->generateJWT($user['id'], $user['email']);

            return $this->response->setStatusCode(200)->setJSON([
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'token' => $token
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get user profile with teacher data
     */
    public function profile()
    {
        $this->response->setHeader('Content-Type', 'application/json');

        $token = $this->getBearerToken();
        if (!$token) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Unauthorized - No token provided'
            ]);
        }

        $payload = $this->verifyJWT($token);
        if (!$payload) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Unauthorized - Invalid token'
            ]);
        }

        try {
            $user = $this->authUserModel->find($payload['user_id']);
            if (!$user) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => false,
                    'message' => 'User not found'
                ]);
            }

            $teacher = $this->teachersModel->where('user_id', $payload['user_id'])->first();

            return $this->response->setStatusCode(200)->setJSON([
                'status' => true,
                'message' => 'Profile retrieved successfully',
                'data' => [
                    'user' => $user,
                    'teacher' => $teacher
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get all teachers with user data
     */
    public function getAllTeachers()
    {
        $this->response->setHeader('Content-Type', 'application/json');

        $token = $this->getBearerToken();
        if (!$token) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Unauthorized - No token provided'
            ]);
        }

        $payload = $this->verifyJWT($token);
        if (!$payload) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Unauthorized - Invalid token'
            ]);
        }

        try {
            $db = \Config\Database::connect();
            $teachers = $db->table('teachers')
                ->select('teachers.*, auth_user.email, auth_user.first_name, auth_user.last_name')
                ->join('auth_user', 'auth_user.id = teachers.user_id')
                ->get()
                ->getResultArray();

            return $this->response->setStatusCode(200)->setJSON([
                'status' => true,
                'message' => 'Teachers retrieved successfully',
                'data' => $teachers
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Validate registration data
     */
    private function validateRegistration($data)
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First name is required';
        }

        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last name is required';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        if (empty($data['university_name'])) {
            $errors['university_name'] = 'University name is required';
        }

        if (empty($data['gender'])) {
            $errors['gender'] = 'Gender is required';
        }

        if (empty($data['year_joined'])) {
            $errors['year_joined'] = 'Year joined is required';
        }

        return $errors;
    }

    /**
     * Generate JWT token
     */
    private function generateJWT($userId, $email)
    {
        $secretKey = env('JWT_SECRET_KEY', 'your_super_secret_jwt_key_here');
        $algorithm = env('JWT_ALGORITHM', 'HS256');
        
        $issuedAt = time();
        $expire = $issuedAt + (60 * 60 * 24); // 24 hours

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expire,
            'user_id' => $userId,
            'email' => $email
        ];

        $header = ['typ' => 'JWT', 'alg' => $algorithm];

        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));

        $signatureInput = $headerEncoded . '.' . $payloadEncoded;
        $signature = $this->base64UrlEncode(hash_hmac('sha256', $signatureInput, $secretKey, true));

        return $signatureInput . '.' . $signature;
    }

    /**
     * Verify JWT token
     */
    private function verifyJWT($token)
    {
        $secretKey = env('JWT_SECRET_KEY', 'your_super_secret_jwt_key_here');

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        $header = json_decode($this->base64UrlDecode($parts[0]), true);
        $payload = json_decode($this->base64UrlDecode($parts[1]), true);
        $signature = $parts[2];

        // Verify signature
        $signatureInput = $parts[0] . '.' . $parts[1];
        $expectedSignature = $this->base64UrlEncode(hash_hmac('sha256', $signatureInput, $secretKey, true));

        if ($signature !== $expectedSignature) {
            return false;
        }

        // Check expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        return $payload;
    }

    /**
     * Get bearer token from Authorization header
     */
    private function getBearerToken()
    {
        $header = $this->request->getHeader('Authorization');
        if (!$header) {
            return null;
        }

        $parts = explode(' ', $header->getValue());
        if (count($parts) !== 2 || $parts[0] !== 'Bearer') {
            return null;
        }

        return $parts[1];
    }

    /**
     * Base64 URL encode
     */
    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Base64 URL decode
     */
    private function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', strlen($data) % 4));
    }
}
