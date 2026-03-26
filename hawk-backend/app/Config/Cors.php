<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
    /**
     * Allow CORS for these domains
     */
    public $allowed_origins = ['http://localhost:3000', 'http://127.0.0.1:3000'];

    /**
     * Allowed HTTP methods
     */
    public $allowed_methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'];

    /**
     * Allowed headers
     */
    public $allowed_headers = [
        'Content-Type',
        'Accept',
        'Authorization',
        'X-Requested-With',
        'X-CSRF-Token'
    ];

    /**
     * Expose headers
     */
    public $exposed_headers = ['Content-Length', 'X-JSON-Response'];

    /**
     * Credentials allowed
     */
    public $allow_credentials = true;

    /**
     * Max age of preflight request (in seconds)
     */
    public $max_age = 3600;
}
