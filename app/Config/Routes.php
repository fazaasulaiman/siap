<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index',['filter' => 'auth']);
$routes->get('/home', 'Home::index',['filter' => 'auth']);
$routes->get('login', 'Home::login');
$routes->get('logout', 'Home::logout');
$routes->get('error', 'Error::page');
$routes->post('login/process', 'Home::process');
$routes->group('register', ['filter' => 'admin'],function ($routes) {
	$routes->get('', 'Register::index');
	$routes->get('pimpinan', 'Register::pimpinan');
	$routes->get('pimpinanJson', 'Register::tablePimpinan');
	$routes->post('process/(:segment)', 'Register::process/$1');
	$routes->post('remove', 'Register::remove');
	$routes->add('seksi/(:segment)/edit', 'Register::edit/$1');
	$routes->get('seksiJson', 'Register::datatable', ['as' => 'dt-json']);
});
$routes->resource('api/negara', ['controller' =>'Country'],['filter' => 'auth']);
$routes->group('penolakan', ['filter' => 'auth'],function ($routes) {
	$routes->get('input', 'Penolakan::input',['filter' => 'seksi']);
	$routes->get('arsip', 'Penolakan::arsip');
	$routes->add('arsipJson', 'Penolakan::arsipJson');
	$routes->post('process', 'Penolakan::process',['filter' => 'seksi']);
	$routes->post('remove', 'Penolakan::remove',['filter' => 'seksi']);
	$routes->post('bapen', 'Penolakan::bapenProcess',['filter' => 'seksi']);
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
