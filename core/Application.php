<?php
require './core/Router.php';

class Application
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router;
    }

    public function run():void
    {
        $this->router->resolve();
    }

    public function setHeaders(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE, PATCH");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
}
