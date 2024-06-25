<?php
namespace Shibaji\Core;

class Router
{
    private $routes = [];
    private $closureRoutes = [];
    private $notFoundHandler;
    private $cacheDir = __DIR__ . '/../cache/';
    private $cacheDuration = 3600; // 1 hour by default

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    public function put($path, $callback)
    {
        $this->addRoute('PUT', $path, $callback);
    }

    public function patch($path, $callback)
    {
        $this->addRoute('PATCH', $path, $callback);
    }

    public function delete($path, $callback)
    {
        $this->addRoute('DELETE', $path, $callback);
    }

    public function head($path, $callback)
    {
        $this->addRoute('HEAD', $path, $callback);
    }

    public function options($path, $callback)
    {
        $this->addRoute('OPTIONS', $path, $callback);
    }

    public function all($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
        $this->addRoute('POST', $path, $callback);
        $this->addRoute('PUT', $path, $callback);
        $this->addRoute('PATCH', $path, $callback);
        $this->addRoute('DELETE', $path, $callback);
        $this->addRoute('HEAD', $path, $callback);
        $this->addRoute('OPTIONS', $path, $callback);
    }

    private function addRoute($method, $path, $callback)
    {
        if ($callback instanceof \Closure) {
            $this->closureRoutes[] = [
                'method' => $method,
                'path' => $path,
                'callback' => $callback,
            ];
        } else {
            $this->routes[] = [
                'method' => $method,
                'path' => $path,
                'callback' => $callback,
            ];
        }
    }

    public function setNotFoundHandler($callback)
    {
        $this->notFoundHandler = $callback;
    }

    public function setCacheDir($dir)
    {
        $this->cacheDir = rtrim($dir, '/') . '/';
    }

    public function setCacheDuration($duration)
    {
        $this->cacheDuration = $duration;
    }

    public function dispatch($method, $uri)
    {
        $urlComponents = parse_url($uri);
        $path = $urlComponents['path'];
        $queryParams = [];
        if (isset($urlComponents['query'])) {
            parse_str($urlComponents['query'], $queryParams);
        }

        $cacheFile = $this->getCacheFilePath($method, $path);
        $route = null;

        if ($this->isCacheValid($cacheFile)) {
            $route = unserialize(file_get_contents($cacheFile));
        } else {
            $route = $this->findRoute($method, $path);
            if ($route && !$route['is_closure']) {
                $this->saveCache($cacheFile, $route);
            }
        }

        if ($route) {
            $params = array_merge($route['params'], $queryParams);
            $request = new Request($params);

            if ($route['is_closure']) {
                call_user_func($route['callback'], $request);
            } else {
                $this->handleCallback($route['callback'], $request, $params);
            }
            return;
        }

        if ($this->notFoundHandler) {
            call_user_func($this->notFoundHandler);
        } else {
            echo "404 Not Found";
        }
    }

    private function findRoute($method, $path)
    {
        foreach (array_merge($this->routes, $this->closureRoutes) as $route) {
            if ($route['method'] === $method && $this->match($route['path'], $path, $params)) {
                return [
                    'callback' => $route['callback'],
                    'params' => $params,
                    'is_closure' => $route['callback'] instanceof \Closure,
                ];
            }
        }
        return null;
    }

    private function match($routePath, $uri, &$params)
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($uri, '/'));

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        $params = [];

        foreach ($routeParts as $index => $part) {
            if (strpos($part, ':') === 0) {
                $params[substr($part, 1)] = $uriParts[$index];
            } elseif ($part !== $uriParts[$index]) {
                return false;
            }
        }

        return true;
    }

    private function getCacheFilePath($method, $path)
    {
        $cacheKey = md5($method . $path);
        return $this->cacheDir . $cacheKey . '.cache';
    }

    private function isCacheValid($cacheFile)
    {
        if (!file_exists($cacheFile)) {
            return false;
        }

        return (time() - filemtime($cacheFile)) < $this->cacheDuration;
    }

    private function saveCache($cacheFile, $data)
    {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }

        file_put_contents($cacheFile, serialize($data));
    }

    private function handleCallback($callback, $request, $params)
    {
        if (is_array($callback) && count($callback) === 2 && class_exists($callback[0])) {
            $controller = new $callback[0]();
            call_user_func([$controller, $callback[1]], $request);
        } elseif (is_string($callback) && strpos($callback, '@') !== false) {
            list($controllerName, $methodName) = explode('@', $callback);
            $controller = new $controllerName;
            call_user_func([$controller, $methodName], $request);
        } elseif ($this->expectsRequestObject($callback)) {
            call_user_func($callback, $request);
        } else {
            call_user_func_array($callback, $params);
        }
    }

    private function expectsRequestObject($callback)
    {
        if (is_array($callback)) {
            $reflection = new \ReflectionMethod($callback[0], $callback[1]);
        } else {
            $reflection = new \ReflectionFunction($callback);
        }

        $params = $reflection->getParameters();
        return !empty($params) && $params[0]->getType() && !$params[0]->getType()->isBuiltin() && $params[0]->getType()->getName() === Request::class;
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $this->dispatch($method, $uri);
    }
}
