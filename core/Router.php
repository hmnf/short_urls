<?php
require './core/Request.php';

class Router{
    public Request $request;
    protected array $routes = [];

    public function __construct()
    {
        $this->request = new Request;
    }

    public function get(string $endPoint, Callable $callbackFunc)
    {
        echo $this->request->uri();
    }
}