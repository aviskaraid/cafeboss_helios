<?php

// Define module routes
$routes->group('pOS', ['namespace' => 'Modules\POS\Controllers'], function($routes) {
    $routes->get('/', 'POSController::index');
    // Add more routes here
});
