<?php
class Router {
    private $routes = [];
    private $basePath = '/mattlam/ssw-ai-assist-training-reports';

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
        
        // Debug information
        error_log("Requested Path: " . $path);
        error_log("Available Routes: " . print_r($this->routes, true));

        if (isset($this->routes[$path])) {
            $controller = $this->routes[$path]['controller'];
            $action = $this->routes[$path]['action'];
            
            error_log("Matching route found. Controller: $controller, Action: $action");
            
            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            error_log("No matching route found for path: $path");
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }
}
