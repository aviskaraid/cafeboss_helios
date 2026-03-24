<?php

// Define module routes
$routes->group('apis', ['namespace' => 'Modules\API\Controllers'], function($routes) {
    $routes->get('test', 'ApiAppsController::index');
    $routes->get('get_access_user_menu/(:any)', 'ApiAppsController::get_access_user_menu/$1');
    $routes->get('get_user_groups', 'ApiAppsController::get_user_groups');
    $routes->get('get_item_category', 'ApiAppsController::get_ItemCategory');
    $routes->get('get_item_units', 'ApiAppsController::get_ItemUnits');
    $routes->get('get_itemLocationByItemsId', 'ApiAppsController::get_ItemLocationByItemsId');
    $routes->get('get_supplier_byitem', 'ApiAppsController::getSupplierByItemsId');
    
    $routes->get('get_ItemDetail', 'ApiAppsController::get_ItemDetail');
    $routes->get('get_CheckParStock', 'ApiAppsController::get_CheckParStock');
    $routes->get('get_itemByLocation', 'ApiAppsController::get_itemByLocation');
    $routes->get('get_itemPrice', 'ApiAppsController::get_ItemPrice');
    $routes->get('get_item_ingredient', 'ApiAppsController::get_ItemIngredient');
    $routes->get('get_warehouse', 'ApiAppsController::get_Warehouse');
    $routes->get('get_itemunits_byItemId', 'ApiAppsController::get_itemUnitsByItemId');
    $routes->get('get_itemingredient_byItemId', 'ApiAppsController::get_itemIngredientByItemId');
    $routes->get('get_foodmenu_category', 'ApiAppsController::get_foodmenu_category');
    $routes->get('get_foodmenu_category_bymenu', 'ApiAppsController::getFoodMenuCategoryByFoodMenu');
    $routes->get('get_foodmenu_category_bystore','ApiAppsController::getFoodMenuCategoryByStore');
    $routes->get('get_foodmenu_bystore','ApiAppsController::getFoodMenuByStore');
    $routes->get('CheckBomFoodMenu','ApiAppsController::get_BomFoodMenu');
    $routes->get('get_StockRequestHeader','ApiAppsController::get_StockRequestHeader');
    $routes->get('get_StockRequestLines','ApiAppsController::get_StockRequestLines');
    
    $routes->get('get_supplier', 'ApiAppsController::getSupplier');
    $routes->get('get_department', 'ApiAppsController::getDepartment');
    $routes->get('get_store', 'ApiAppsController::getStore');
    $routes->get('get_employeegroup', 'ApiAppsController::getEmployeeGroup');
    $routes->get('get_employee', 'ApiAppsController::getEmployee');
    $routes->get('get_pos_table_area','ApiAppsController::getPosTableArea');
    $routes->get('get_pos_table','ApiAppsController::getPosTable');
    $routes->get('get_customer','ApiAppsController::getCustomer');
    $routes->get('get_taktikal_bysupplier','ApiAppsController::get_TaktikalBySupplier');



    $routes->get('get_PurchaseRequestHeader','ApiAppsController::get_PurchaseRequestHeader');
    $routes->get('get_PurchaseRequestLines','ApiAppsController::get_PurchaseRequestLines');
    // APPROVEDD//

    $routes->post('post_SRApprove','ApiAppsController::post_updateApproveSR');
    $routes->post('post_SRDecline','ApiAppsController::post_updateDeclineSR');
    $routes->post('post_PRApprove','ApiAppsController::post_updateApprovePR');
    $routes->post('post_PRDecline','ApiAppsController::post_updateDeclinePR');
    $routes->get('post_removePRItem','ApiAppsController::post_removePRItem');
});
