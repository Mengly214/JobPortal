<?php
class Router {
    private array $routes = [];

    public function get(string $uri, string $controller, string $method): void {
        $this->routes['GET'][$uri] = [$controller, $method];
    }

    public function post(string $uri, string $controller, string $method): void {
        $this->routes['POST'][$uri] = [$controller, $method];
    }

    public function any(string $uri, string $controller, string $method): void {
        $this->routes['GET'][$uri]  = [$controller, $method];
        $this->routes['POST'][$uri] = [$controller, $method];
    }

    public function dispatch(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $uri           = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base          = rtrim(parse_url(SITE_URL, PHP_URL_PATH), '/');
        $uri           = '/' . ltrim(substr($uri, strlen($base)), '/');
        $uri           = rtrim($uri, '/') ?: '/';

        // 1. Exact match
        if (isset($this->routes[$requestMethod][$uri])) {
            [$ctrl, $action] = $this->routes[$requestMethod][$uri];
            $this->call($ctrl, $action, []);
            return;
        }

        // 2. Dynamic :param match
        foreach ($this->routes[$requestMethod] ?? [] as $route => $handler) {
            $pattern = preg_replace('#:([a-zA-Z0-9_]+)#', '([^/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches);
                [$ctrl, $action] = $handler;
                $this->call($ctrl, $action, $matches);
                return;
            }
        }

        // 3. 404
        http_response_code(404);
        echo '<!DOCTYPE html><html><body style="font-family:sans-serif;padding:40px">
              <h1>404 &mdash; Page Not Found</h1>
              <p><a href="' . SITE_URL . '/">Go to Homepage</a></p>
              </body></html>';
    }

    private function call(string $controller, string $action, array $params): void {
        $path = BASE_PATH . '/app/Controllers/' . str_replace('/', DIRECTORY_SEPARATOR, $controller) . '.php';
        if (!file_exists($path)) die("Controller not found: $controller");
        require_once $path;
        // Build class name: "Admin/ProfileController" → "Admin_ProfileController"
        $className = str_replace('/', '_', $controller);
        $obj = new $className();
        $obj->$action(...$params);
    }
    
}
