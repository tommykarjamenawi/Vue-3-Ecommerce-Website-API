<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// routes for the products endpoint
$router->get('/products', 'ProductController@getAll');
$router->get('/products/(\d+)', 'ProductController@getById');
$router->post('/products', 'ProductController@create');
$router->put('/products/(\d+)', 'ProductController@update');
$router->delete('/products/(\d+)', 'ProductController@delete');

// routes for the users endpoint
$router->post('/users/login', 'UserController@login');
$router->get('/users', 'UserController@getAll');
$router->get('/users/(\d+)', 'UserController@getById');
$router->post('/users', 'UserController@register');
$router->delete('/users/(\d+)', 'UserController@delete');
$router->put('/users/(\d+)', 'UserController@update');
$router->put('/users/(\d+)/password', 'UserController@updatePassword');

// routes for the orders endpoint
$router->get('/orders', 'OrderController@getAll');
$router->get('/orders/(\d+)', 'OrderController@getOne');
$router->post('/orders', 'CartController@pay');


// Run it!
$router->run();