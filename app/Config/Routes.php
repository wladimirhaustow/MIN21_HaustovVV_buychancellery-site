<?php namespace Config;

// Create a new instance of our RouteCollection class.
use CodeIgniter\CodeIgniter;
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// Авторизация
$routes->group('Auth', ['filter' => 'auth:noauth'], function(RouteCollection $routes)
{
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');

    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');

    $routes->get('logout', 'Auth::logout', ['filter' => 'auth']);

});


$routes->group('Product', ['filter' => 'auth'], function(RouteCollection $routes)
{
    $routes->get('getProduct', 'Product::get');
    $routes->post('setProduct', 'Product::set', ['filter' => 'auth:admin']);
});

$routes->group('Request', ['filter' => 'auth'], function(RouteCollection $routes)
{
    $routes->get('getRequest', 'Request::get');
    $routes->post('setRequest', 'Request::set');
    $routes->post('send', 'Request::send');
});

$routes->group('Purchaser', ['filter' => 'auth:purchaser'], function(RouteCollection $routes)
{
    $routes->get('get', 'Purchaser::get');
    $routes->get('getRequest/(:num)', 'Request::getByUserId/$1');
});



/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
