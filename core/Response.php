<?php

class Response {
    public function json(array $args): string 
    {
        return json_encode($args);
    }
}