<?php

// Define module routes
$routes->group('beranda', ['namespace' => 'Modules\Beranda\Controllers'], function($routes) {
    $routes->get('/', 'BerandaController::index');
    // Add more routes here
});
