<?php
require './core/Request.php';

class Router
{
    public Request $request;
    protected array $routes = [
        "get" => [],
        "post" => [],
        "patch" => [],
        "put" => [],
        "delete" => []
    ];

    public function __construct()
    {
        $this->request = new Request;
    }

    public function addRoute(string $method, string $endPoint, callable $callbackFunc)
    {
        $endPoint = rtrim($endPoint, "/");
        $endPoint = ltrim($endPoint, "/");
        $this->routes[$method][$endPoint] = ["callback" => $callbackFunc];
    }

    public function get(string $endPoint, callable $callbackFunc)
    {
        $this->addRoute("get", $endPoint, $callbackFunc);
    }

    public function post(string $endPoint, callable $callbackFunc)
    {
        $this->addRoute("post", $endPoint, $callbackFunc);
    }

    public function put(string $endPoint, callable $callbackFunc)
    {
        $this->addRoute("put", $endPoint, $callbackFunc);
    }

    public function patch(string $endPoint, callable $callbackFunc)
    {
        $this->addRoute("patch", $endPoint, $callbackFunc);
    }

    public function delete(string $endPoint, callable $callbackFunc)
    {
        $this->addRoute("delete", $endPoint, $callbackFunc);
    }

    public function resolve()
    {
        $methodRoute = $this->routes[$this->request->method()];

        $uri = $this->request->uri();
        if(array_key_exists($uri, $methodRoute)){
            $route = $methodRoute[$uri];
            call_user_func($route["callback"]);
        }else{
            header("HTTP/1.1 404 Page Not Found");
        }
    }
}
