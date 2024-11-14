<?php
require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

require basePath('Framework/Router.php');
require basePath('Framework/Database.php');
require basePath('Framework/Validation.php');

use Framework\Router;

// Instantiate the router
$router = new Router();

// Get routes
$routes = require basePath('routes.php');

// Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
$router->route($uri);
