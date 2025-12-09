<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/home', ['Home','Home::index']);
// $routes->addRedirect('/', 'home');
// $routes->get('/home', 'dashboard');
$routes->addRedirect('/', 'beranda');

// HMVC Routes
$modules = scandir(APPPATH . 'Modules');
foreach ($modules as $module) {
    if ($module === '.' || $module === '..') continue;
    if (is_dir(APPPATH . 'Modules/' . $module)) {
        $routesPath = APPPATH . 'Modules/' . $module . '/Config/Routes.php';
        if (file_exists($routesPath)) {
            require $routesPath;
        }
    }
}