<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $corsConfig = new \Config\Cors();
        $origin = $request->getHeaderLine('Origin');

        if ($request->getMethod() === 'options') {
            $this->handlePreflightRequest();
        }

        // Only set CORS headers if the origin matches our allowed list
        if (in_array($origin, $corsConfig->allowed_origins) || $corsConfig->allowed_origins[0] === '*') {
            return $this->setCorsHeaders($request->getMethod());
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $corsConfig = new \Cors\Config();
        $origin = $request->getHeaderLine('Origin');

        if (in_array($origin, $corsConfig->allowed_origins) || $corsConfig->allowed_origins[0] === '*') {
            $response->setHeader('Access-Control-Allow-Origin', $origin);
            $response->setHeader('Access-Control-Allow-Methods', implode(', ', $corsConfig->allowed_methods));
            $response->setHeader('Access-Control-Allow-Headers', implode(', ', $corsConfig->allowed_headers));
            $response->setHeader('Access-Control-Expose-Headers', implode(', ', $corsConfig->exposed_headers));
            if ($corsConfig->allow_credentials) {
                $response->setHeader('Access-Control-Allow-Credentials', 'true');
            }
        }

        return $response;
    }

    private function handlePreflightRequest()
    {
        $corsConfig = new \Config\Cors();
        $response = service('response');
        $response->setHeader('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN'] ?? '*');
        $response->setHeader('Access-Control-Allow-Methods', implode(', ', $corsConfig->allowed_methods));
        $response->setHeader('Access-Control-Allow-Headers', implode(', ', $corsConfig->allowed_headers));
        $response->setHeader('Access-Control-Max-Age', $corsConfig->max_age);

        exit;
    }

    private function setCorsHeaders($method)
    {
        $corsConfig = new \Config\Cors();
        $response = service('response');
        $origin = $GLOBALS['_SERVER']['HTTP_ORIGIN'] ?? '*';
        $response->setHeader('Access-Control-Allow-Origin', $origin);
        $response->setHeader('Access-Control-Allow-Methods', implode(', ', $corsConfig->allowed_methods));
        $response->setHeader('Access-Control-Allow-Headers', implode(', ', $corsConfig->allowed_headers));

        return null;
    }
}
