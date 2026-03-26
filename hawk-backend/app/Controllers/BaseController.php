<?php

namespace App\Controllers;

class BaseController extends \CodeIgniter\Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    public function __construct()
    {
        parent::__construct();
        
        // Set CORS headers for API
        header('Access-Control-Allow-Origin: ' . (getenv('ALLOW_CORS_ORIGIN') ?: 'http://localhost:3000'));
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept');
        header('Access-Control-Allow-Credentials: true');

        // Handle preflight requests
        if ($this->request->getMethod() === 'options') {
            http_response_code(200);
            exit();
        }
    }
}
