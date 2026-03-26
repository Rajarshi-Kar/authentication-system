<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');

// Health check
$routes->get('/', 'Home::index');

// Auth routes (public)
$routes->post('api/auth/register', 'AuthController::register');
$routes->post('api/auth/login', 'AuthController::login');

// Protected routes (require JWT token)
$routes->get('api/profile', 'AuthController::profile');
$routes->get('api/teachers', 'AuthController::getAllTeachers');

// 404 handler
$routes->setAutoRoute(false);
