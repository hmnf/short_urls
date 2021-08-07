<?php

class Request{

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function uri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = ltrim($uri, '/');
        $uri = rtrim($uri, '/');
        return $uri;
    }
}