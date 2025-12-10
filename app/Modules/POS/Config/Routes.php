<?php

// Define module routes
$routes->group('posmain', ['namespace' => 'Modules\POS\Controllers'], function($routes) {
    $routes->get('/', 'MainController::index');
    // Add more routes here
});
