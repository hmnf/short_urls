<?php

require './core/Application.php';
require './controllers/User.php';
require './authorization/Auth.php';

$app = new Application;
$app->setHeaders();

$app->router->post('/sign-up', [Auth::class, 'Registration']);

// $app->router->get('/users', [User::class, 'getAll']);
// $app->router->get('/user/:id', [User::class, 'getUser']);
// $app->router->post('/users/create', [User::class, 'createUser']);

$app->run();
