<?php
require './core/Request.php';

class Router{
    public Request $request;
    protected array $routes = [];

    public function __construct()
    {
        $this->request = new Request;
    }

    public function routes(string $endPoint, Callable $callbackFunc)
    {
        $uri = $this->request->uri();
        if($endPoint == $uri){
            return call_user_func($callbackFunc);
        }
    }

    public function get(string $endPoint, Callable $callbackFunc)
    {
        $this->routes($endPoint, $callbackFunc);
    }

    public function post(string $endPoint, Callable $callbackFunc)
    {
        $this->routes($endPoint, $callbackFunc);
    }

    public function put(string $endPoint, Callable $callbackFunc)
    {
        $this->routes($endPoint, $callbackFunc);
    }

    public function patch(string $endPoint, Callable $callbackFunc)
    {
        $this->routes($endPoint, $callbackFunc);
    }

    public function delete(string $endPoint, Callable $callbackFunc)
    {
        $this->routes($endPoint, $callbackFunc);
    }
}