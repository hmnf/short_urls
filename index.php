<?php

require './core/Application.php';
require './controllers/User.php';

$app = new Application;
$app->setHeaders();

$app->router->get('/users', [User::class, 'getAll']);
$app->router->get('/user/:id', [User::class, 'getUser']);
$app->router->post('/users/create', [User::class, 'createUser']);

$app->router->get('/users/:id/delete/:name', function (int $id, string $name) {
    echo 'user - ' . $id . ' name - ' . $name;
});

$app->router->get('/pages', function () {
    echo 'pages';
});

$app->router->get('/urls', function () {
    echo 'url';
});

$app->router->post('/url', function () {
    echo 'url';
});

$app->router->patch('/patch', function () {
    echo 'patch';
});

$app->router->delete('/delete', function () {
    echo 'delete';
});

$app->router->put('/put', function () {
    echo 'put';
});

$app->run();
