<?php
require './core/Request.php';

class Router
{
    public Request $request;
    protected array $routes = [];

    public function __construct()
    {
        $this->request = new Request;
    }

    public function routes(string $endPoint, callable $callbackFunc, string $funcMethod)
    {
        $method = $this->request->method();
        $uri = $this->request->uri();
        $uri = rtrim($uri, '/');
        if ($endPoint == $uri) {
            if ($method == $funcMethod) {
                return call_user_func($callbackFunc);
            } else {
                return 'ERROR: method is not correct';
            }
        } else {
            return 'ERROR: rout with this end point not exists';
        }
    }

    public function get(string $endPoint, callable $callbackFunc)
    {
        $funcMethod = 'get';
        $this->routes($endPoint, $callbackFunc, $funcMethod);
    }

    public function post(string $endPoint, callable $callbackFunc)
    {
        $funcMethod = 'post';
        $this->routes($endPoint, $callbackFunc, $funcMethod);
    }

    public function put(string $endPoint, callable $callbackFunc)
    {
        $funcMethod = 'put';
        $this->routes($endPoint, $callbackFunc, $funcMethod);
    }

    public function patch(string $endPoint, callable $callbackFunc)
    {
        $funcMethod = 'patch';
        $this->routes($endPoint, $callbackFunc, $funcMethod);
    }

    public function delete(string $endPoint, callable $callbackFunc)
    {
        $funcMethod = 'delete';
        $this->routes($endPoint, $callbackFunc, $funcMethod);
    }
}
