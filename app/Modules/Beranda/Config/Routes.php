<?php

// Define module routes
$routes->group('beranda', ['filter' => 'isLoggedIn','namespace' => 'Modules\Beranda\Controllers'], function($routes) {
    $routes->get('/', 'BerandaController::index');
    // Add more routes here
});
