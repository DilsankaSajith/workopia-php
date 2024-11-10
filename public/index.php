<?php
require '../helpers.php';

require basePath('Router.php');

$router = new Router();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$routes = require basePath('routes.php');

$router->route($uri, $method);
