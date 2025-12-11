<?php

// Define module routes
$routes->group('posmain', ['namespace' => 'Modules\POS\Controllers'], function($routes) {
    $routes->get('/', 'MainController::index');
    $routes->post('check_openshift','MainController::check_openshift');
     $routes->post('start_shift', 'MainController::start_shift');
    // Add more routes here
});
