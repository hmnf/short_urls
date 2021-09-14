<?php

class Response {
    public function json(mixed $args): void 
    {
        echo json_encode($args);
    }
}