<?php

class Response {
    public function json(array $args): void 
    {
        echo json_encode($args);
    }
}