<?php

// Define module routes
$routes->group('posmain', ['namespace' => 'Modules\POS\Controllers'], function($routes) {
    $routes->get('/', 'MainController::index');
    $routes->get('pos', 'MainController::indexpos');
    $routes->post('check_openshift','MainController::check_openshift');
    $routes->post('start_shift', 'MainController::start_shift');
    $routes->post('inputTransaction', 'MainController::inputTransaction'); 
    $routes->get('getProducts/(:any)', 'MainController::getProducts/$1');
    $routes->get('getProductsLines/(:any)', 'MainController::getProductsLines/$1');
     $routes->get('getMemberLines/(:any)', 'MainController::getMemberLines/$1'); 
    // Add more routes here
});

$routes->group('widget', ['namespace' => 'Modules\POS\Controllers'], function($routes) {
    $routes->post('pending_transaction','WidgetController::pending_transactions');    
});
