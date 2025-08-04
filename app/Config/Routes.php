<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/slider', 'SliderController::index');
$routes->get('/slider/create', 'SliderController::create');
$routes->post('/slider/store', 'SliderController::store');
$routes->get('/slider/edit/(:num)', 'SliderController::edit/$1');
$routes->post('/slider/update/(:num)', 'SliderController::update/$1');

$routes->get('/users', 'UserController::index');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->get('/users/delete/(:num)', 'UserController::delete/$1');
