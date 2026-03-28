<?php

// Define module routes
$routes->group('purchase', ['filter' => 'isLoggedIn','namespace' => 'Modules\Purchase\Controllers'], function($routes) {
    // $routes->get('/', 'PurchaseController::index');
    $routes->get('stockrequest', 'StockRequestController::index');
    $routes->get('purchaserequest', 'PurchaseRequestController::index');
    $routes->get('purchaseorder', 'PurchaseOrderController::index');
    $routes->get('goodreceive', 'PurchaseGoodReceiveController::index');

    $routes->get('stockrequest/create', 'StockRequestController::create');
    $routes->post('stockrequest/create_process','StockRequestController::create_process');
    $routes->post('stockrequest/changes','StockRequestController::changes');
    $routes->get('stockrequest/(:any)', 'StockRequestController::edit/$1');
    
    $routes->get('purchaserequest/create', 'PurchaseRequestController::create');
    $routes->post('purchaserequest/create_process','PurchaseRequestController::create_process');
    $routes->get('purchaserequest/(:any)', 'PurchaseRequestController::edit/$1');
    $routes->post('purchaserequest/changes','PurchaseRequestController::changes');

    $routes->get('purchaseorder/create', 'PurchaseOrderController::create');
    $routes->post('purchaseorder/create_process','PurchaseOrderController::create_process');
    $routes->get('purchaseorder/(:any)', 'PurchaseOrderController::edit/$1');
    $routes->post('purchaseorder/changes','PurchaseOrderController::changes');

    $routes->get('goodreceive/create', 'PurchaseGoodReceiveController::create');
    $routes->post('goodreceive/create_process','PurchaseGoodReceiveController::create_process');
    $routes->get('goodreceive/(:any)', 'PurchaseGoodReceiveController::edit/$1');
    $routes->post('goodreceive/changes','PurchaseGoodReceiveController::changes');
    // Add more routes here
});
