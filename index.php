<?php
// Entry point of the application
require_once 'config/config.php';
require_once 'core/Router.php';
require_once 'controllers/HomeController.php';

// Initialize router
$router = new Router();

// Define routes
$router->addRoute('/', ['controller' => 'HomeController', 'action' => 'index']);

// Handle the request
$router->dispatch();