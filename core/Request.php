<?php

class Request{

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function trimString(string $elem, string $separator): string
    {
        $result = ltrim($elem, $separator);
        $result = rtrim($result, $separator);
        return $result;
    }

    public function uri()
    {
        $uri = $this->trimString($_SERVER['REQUEST_URI'], "/");
        return $uri;
    }

    public function uriChunks(): array
    {
        $chunks = explode("/", $this->uri());
        return $chunks;
    }
}