<?php

// Define module routes
$routes->group('inventory', ['namespace' => 'Modules\Inventory\Controllers'], function($routes) {
    $routes->get('/', 'InventoryController::index');
    // Add more routes here
});
