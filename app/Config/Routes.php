<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
//$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'authGuard']);

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('employee', 'Employee::index');
    $routes->get('/employee/create', 'Employee::create');
    $routes->post('/employee/store', 'Employee::store');
    $routes->get('/employee/edit/(:num)', 'Employee::edit/$1');
    $routes->post('/employee/update/(:num)', 'Employee::update/$1');
    $routes->get('/employee/delete/(:num)', 'Employee::delete/$1');
    $routes->post('employee/deleteImage/(:num)', 'Employee::deleteImage/$1');
    $routes->get('/employee/getRecord/(:num)', 'Employee::getRecord/$1');
    //$routes->get('profile', 'User::profile');
});

$routes->get('auth/verify/(:segment)', 'AuthController::verify/$1');



// $routes->get('/employee', 'Employee::index', ['filter' => 'auth']);
// $routes->get('/employee/create', 'Employee::create');
// $routes->post('/employee/store', 'Employee::store');
// //$routes->post('/employee/storeAjax', 'Employee::storeAjax');
// //$routes->post('/employee/updateAjax/(:num)', 'Employee::updateAjax/$1');
// $routes->get('/employee/edit/(:num)', 'Employee::edit/$1');
// $routes->post('/employee/update/(:num)', 'Employee::update/$1');
// $routes->get('/employee/delete/(:num)', 'Employee::delete/$1');
// $routes->post('employee/deleteImage/(:num)', 'Employee::deleteImage/$1');
// $routes->get('/employee/getRecord/(:num)', 'Employee::getRecord/$1');
