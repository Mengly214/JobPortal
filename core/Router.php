<?php
class Router {
    private array $routes = [];

    // Register GET route
    public function get(string $uri, string $controller, string $method): void {
        $this->routes['GET'][$uri] = [$controller, $method];
    }

    // Register POST route
    public function post(string $uri, string $controller, string $method): void {
        $this->routes['POST'][$uri] = [$controller, $method];
    }

    // Register route for both GET and POST
    public function any(string $uri, string $controller, string $method): void {
        $this->routes['GET'][$uri] = [$controller, $method];
        $this->routes['POST'][$uri] = [$controller, $method];
    }

    // Dispatch the request
    public function dispatch(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove base path (if your site is in a subfolder)
        $base = rtrim(parse_url(SITE_URL, PHP_URL_PATH), '/');
        $uri = '/' . ltrim(substr($uri, strlen($base)), '/');
        $uri = rtrim($uri, '/') ?: '/';

        // 1. Exact match
        if (isset($this->routes[$requestMethod][$uri])) {
            [$controller, $action] = $this->routes[$requestMethod][$uri];
            $this->call($controller, $action, []);
            return;
        }

        // 2. Dynamic :param match
        foreach ($this->routes[$requestMethod] ?? [] as $route => $handler) {
            // Convert :param to regex
            $pattern = preg_replace('#:([a-zA-Z0-9_]+)#', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // remove full match
                [$controller, $action] = $handler;
                $this->call($controller, $action, $matches);
                return;
            }
        }

        // 3. Not found
        http_response_code(404);
        echo '<!DOCTYPE html><html><body style="font-family:sans-serif;padding:40px">
              <h1>404 &mdash; Page Not Found</h1>
              <p><a href="' . SITE_URL . '/">Go to Homepage</a></p>
              </body></html>';
    }

    // Call controller and method
    private function call(string $controller, string $action, array $params): void {
        $path = BASE_PATH . '/app/Controllers/' . str_replace('/', DIRECTORY_SEPARATOR, $controller) . '.php';

        if (!file_exists($path)) {
            die("Controller not found: $controller");
        }

        require_once $path;

        // Convert "Employer/ApplicationsController" → "Employer_ApplicationsController"
        $className = str_replace('/', '_', $controller);

        if (!class_exists($className)) {
            die("Controller class not found: $className");
        }

        $obj = new $className();

        if (!method_exists($obj, $action)) {
            die("Method '$action' not found in controller $className");
        }

        // Call method with parameters
        $obj->$action(...$params);
    }
}