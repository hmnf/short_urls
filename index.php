<?php

require './core/Application.php';
require './models/Model.php';
require './controllers/UserController.php';
require './authorization/Auth.php';

$app = new Application;
$app->setHeaders();

$app->router->post('/sign-up', [Auth::class, 'Registration']);
$app->router->post('/users', [UserController::class, 'createUser']);
$app->router->get('/users/:id', [UserController::class, 'getUser']);
$app->router->delete('/users/:id', [UserController::class, 'delete']);

// $app->router->get('/users', [User::class, 'getAll']);
// $app->router->get('/user/:id', [User::class, 'getUser']);
// $app->router->post('/users/create', [User::class, 'createUser']);

$app->run();
