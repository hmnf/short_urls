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

        $uriChunks = $this->request->uriChunks();
        $params = [];
        $explEndPoint = explode("/", $endPoint);

        foreach($explEndPoint as $key => $chunk){
            if(str_starts_with($chunk, ":")){
                $params[] = $uriChunks[$key];
            }
        }

        $this->routes[$method][$endPoint] = ["callback" => $callbackFunc, "params" => $params];
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
        $route = [];
        
        foreach($methodRoute as $routeName => $routeValue){
            $expRouteName = explode("/", $routeName);
            if(count($expRouteName) === count($this->request->uriChunks()) && $expRouteName[0] === $this->request->uriChunks()[0]){
                $route = $routeValue;
            }
        }

        if(count($route) !== 0){
            call_user_func_array($route["callback"], $route["params"]);
        }else{
            header("HTTP/1.1 404 Page Not Found");
        }
    }
}
