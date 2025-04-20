<?php
class Router {
    private $routes = [];
    private $basePath = '/mattlam/ssw-ai-assist-training-reports';

    public function __construct() {
        // Add routes
        $this->addRoute('/', ['controller' => 'HomeController', 'action' => 'index']);
        $this->addRoute('/reports/by-person', ['controller' => 'ReportsController', 'action' => 'byPerson']);
        $this->addRoute('/reports/expired', ['controller' => 'ReportsController', 'action' => 'expired']);
    }

    public function addRoute($path, $handler) {
        $this->routes[$path] = $handler;
    }

    public function dispatch() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($path, PHP_URL_PATH);
        
        // Remove base path from the request URI
        if (strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }
        
        // Ensure path starts with /
        $path = '/' . ltrim($path, '/');

        if (isset($this->routes[$path])) {
            $controller = $this->routes[$path]['controller'];
            $action = $this->routes[$path]['action'];
            
            require_once APP_ROOT . '/controllers/' . $controller . '.php';
            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }
}

