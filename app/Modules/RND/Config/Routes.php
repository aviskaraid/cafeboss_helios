<?php

// Define module routes
$routes->group('rnd', ['filter' => 'isLoggedIn','namespace' => 'Modules\RND\Controllers'], function($routes) {
    $routes->get('/', 'RNDController::index');
    $routes->get('create', 'RNDController::create');
    $routes->get('generate_rnd_code','RNDController::generate_rnd_code');
    $routes->post('create_process','RNDController::create_process');
    $routes->get('edit/(:any)', 'RNDController::edit/$1');
    $routes->patch('changes/(:any)', 'RNDController::changes/$1');
    // Add more routes here
});
