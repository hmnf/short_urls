<?php

class Request{

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}