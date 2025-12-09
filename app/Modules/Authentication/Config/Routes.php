<?php

// Define module routes
$routes->group('authentication', ['namespace' => 'Modules\Authentication\Controllers'], function($routes) {
    $routes->get('login', 'AuthenticationController::login');
    $routes->get('register', 'AuthenticationController::register');
    $routes->post('login_process', 'AuthenticationController::login_process');
     $routes->get('logout', 'AuthenticationController::logout');
    // Add more routes here
});


