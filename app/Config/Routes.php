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
$routes->post('/slider/reorder', 'SliderController::reorder');
$routes->get('/slider/delete/(:num)', 'SliderController::delete/$1');

$routes->get('/users', 'UserController::index');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->get('/users/delete/(:num)', 'UserController::delete/$1');

$routes->get('/post', 'PostController::index');
$routes->get('/post/create', 'PostController::create');

$routes->post('/post/store', 'PostController::store');
$routes->get('/post/edit/(:num)', 'PostController::edit/$1');
$routes->post('/post/update/(:num)', 'PostController::update/$1');
$routes->get('/post/delete/(:num)', 'PostController::delete/$1');
$routes->post('/post/reorder', 'PostController::reorder');

$routes->get('/item', 'ItemController::index');
$routes->post('/item/create/(:num)', 'ItemController::create/$1');
$routes->post('/item/store', 'ItemController::store');
$routes->get('/item/edit/(:num)', 'ItemController::edit/$1');
$routes->post('/item/update/(:num)', 'ItemController::update/$1');
$routes->post('/item/reorder', 'ItemController::reorder');
$routes->get('/item/delete/(:num)', 'ItemController::delete/$1');

$routes->post('/collection/updateKey', 'CollectionController::updateKey');

$routes->get('/contact', 'CompanyContactController::index');
$routes->post('/contact/update', 'CompanyContactController::update');

$routes->get('/footer', 'FooterController::index');
$routes->post('/footer/update', 'FooterController::update');

$routes->get('/message', 'MessageController::index');
$routes->post('/message/store', 'MessageController::store');


$routes->group('api', [
    'namespace' => 'App\Controllers\Api',
    'filter' => 'cors'
], function ($routes) {
    $routes->resource('sliders', ['controller' => 'SliderController']);
    $routes->resource('posts', ['controller' => 'PostController']);
    $routes->resource('contact', ['controller' => 'CompanyContactController']);
    $routes->resource('footer', ['controller' => 'FooterController']);
});


