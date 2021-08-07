<?php 

require './core/Application.php';

$app = new Application;

$app->router->get('/users/user', function(){
    echo 'user';
});

$app->router->post('/url', function(){
    echo 'url';
});

$app->router->patch('/patch', function(){
    echo 'patch';
});

$app->router->delete('/delete', function(){
    echo 'delete';
});

$app->router->put('/put', function(){
    echo 'put';
});

$app->run();