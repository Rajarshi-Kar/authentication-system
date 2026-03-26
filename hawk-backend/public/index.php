<?php
// This file is the public entry point for CodeIgniter 4

// Set the error reporting level
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', '1');

// Check PHP version
$minPHPVersion = '7.4';
if (phpversion() < $minPHPVersion) {
    die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . phpversion());
}

// Define the public path here
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
// on windows this will just added the file
require rtrim(dirname(__FILE__), '/\\') . '/../vendor/autoload.php';

// Codigniter 4 entry point
require rtrim(dirname(__FILE__), '/\\') . '/../vendor/codeigniter4/framework/system/Commands/Serve/rewrite.php';
