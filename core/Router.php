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

    public function arrayRoute(string $endPoint, callable $callbackFunc)
    {
        $endPoint = rtrim($endPoint, "/");
        $endPoint = ltrim($endPoint, "/");
        return [$endPoint => ["callback" => $callbackFunc]];
    }

    public function get(string $endPoint, callable $callbackFunc)
    {
        $this->routes["get"] = $this->arrayRoute($endPoint, $callbackFunc);
    }

    public function post(string $endPoint, callable $callbackFunc)
    {
        $this->routes["post"] = $this->arrayRoute($endPoint, $callbackFunc);
    }

    public function put(string $endPoint, callable $callbackFunc)
    {
        $this->routes["put"] = $this->arrayRoute($endPoint, $callbackFunc);
    }

    public function patch(string $endPoint, callable $callbackFunc)
    {
        $this->routes["patch"] = $this->arrayRoute($endPoint, $callbackFunc);
    }

    public function delete(string $endPoint, callable $callbackFunc)
    {
        $this->routes["delete"] = $this->arrayRoute($endPoint, $callbackFunc);
    }

    public function resolve()
    {
        if(array_key_exists($this->request->method(), $this->routes)){
            $methodRoute = $this->routes[$this->request->method()];
        }
        if(count($methodRoute) != 0){
            $uri = $this->request->uri();
            $callbackKey = $methodRoute[$uri];
            $callbackFunc = $callbackKey["callback"];
            if(array_key_exists($uri, $methodRoute)){
                call_user_func($callbackFunc);
            }else{
                header("HTTP/1.1 404 Page Not Found");
                exit();
            }
        }else{
            header("HTTP/1.1 400 Bad Request");
            exit();
        }
    }
}
