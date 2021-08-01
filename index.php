<?php 

require './core/Application.php';

$app = new Application;

$app->router->get('/users', function(){
    echo 'users';
});

$app->router->get('/url', function(){
    echo 'url';
});

$app->router->get('/test', function(){
    echo 'test';
});