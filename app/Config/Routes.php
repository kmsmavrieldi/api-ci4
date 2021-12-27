<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('register', 'UserController::registerForm');
$routes->post('register', 'UserController::register');
$routes->get('login', 'UserController::loginForm');
$routes->post('login', 'UserController::login');

//restApi
$routes->group('api', function ($routes) {
    // $routes->post('register', 'UserController::register');
    // $routes->post('login', 'UserController::login');
    $routes->get('details', 'UserAPI::details',['filter' => 'APIauth']);
    
});
$routes->group('api', ['filter' => 'APIauth'], function ($routes) {
    $routes->get('inventory', 'InventoryAPI::index');
    $routes->post('inventory', 'InventoryAPI::create');
    $routes->get('inventory/(:segment)', 'InventoryAPI::show/$1');
    $routes->put('inventory/(:segment)', 'InventoryAPI::update/$1');
    $routes->delete('inventory/(:segment)', 'InventoryAPI::delete/$1');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
