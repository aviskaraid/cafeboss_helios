<?php

// Define module routes
$routes->group('taktikal',  ['filter' => 'isLoggedIn','namespace' => 'Modules\TAKTIKAL\Controllers'], function($routes) {
    $routes->get('/', 'TAKTIKALController::index');
    $routes->get('create', 'TAKTIKALController::create');
    $routes->get('generate_code','TAKTIKALController::generate_code');
    $routes->post('create_process', 'TAKTIKALController::create_process');
    $routes->post('changes', 'TAKTIKALController::changes');
     $routes->get('edit/(:any)', 'TAKTIKALController::edit/$1');
    // Add more routes here
});
