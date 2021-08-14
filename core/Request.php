<?php

class Request
{
    public array $data = [];
    public array $args = [];

    public function __construct()
    {
        $this->args = $_GET;
    }

    public function storeData(array $data)
    {
        $content = file_get_contents('php://input');
        $decoded_content = json_decode($content, TRUE);

        if(!is_array($decoded_content)){
            $decoded_content = [];
        }

        $this->data = array_merge($this->data, $data, $decoded_content, $_POST);
    }

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
