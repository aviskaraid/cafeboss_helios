<?php

// Define module routes
$routes->group('posmain', ['filter' => 'isLoggedIn','namespace' => 'Modules\POS\Controllers'], function($routes) {
    $routes->get('/', 'MainController::index');
    $routes->post('check_openshift','MainController::check_openshift');
     $routes->post('start_shift', 'MainController::start_shift');
     $routes->post('inputTransaction', 'MainController::inputTransaction'); 
    // Add more routes here
});
