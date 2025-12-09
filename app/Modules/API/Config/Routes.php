<?php

// Define module routes
$routes->group('apis', ['namespace' => 'Modules\API\Controllers'], function($routes) {
    $routes->get('test', 'ApiAppsController::index');
    $routes->get('get_access_user_menu/(:any)', 'ApiAppsController::get_access_user_menu/$1');
    $routes->get('get_user_groups', 'ApiAppsController::get_user_groups');
    $routes->get('get_item_category', 'ApiAppsController::get_ItemCategory');
    $routes->get('get_item_units', 'ApiAppsController::get_ItemUnits');
    $routes->get('get_item_ingredient', 'ApiAppsController::get_ItemIngredient');
    $routes->get('get_warehouse', 'ApiAppsController::get_Warehouse');
    $routes->get('get_itemunits_byItemId', 'ApiAppsController::get_itemUnitsByItemId');
    $routes->get('get_itemingredient_byItemId', 'ApiAppsController::get_itemIngredientByItemId');
    $routes->get('get_foodmenu_category', 'ApiAppsController::get_foodmenu_category');
    $routes->get('get_foodmenu_category_bymenu', 'ApiAppsController::getFoodMenuCategoryByFoodMenu');
    $routes->get('get_foodmenu_category_bystore','ApiAppsController::getFoodMenuCategoryByStore');
    $routes->get('get_department', 'ApiAppsController::getDepartment');
    $routes->get('get_store', 'ApiAppsController::getStore');
    $routes->get('get_employeegroup', 'ApiAppsController::getEmployeeGroup');
    $routes->get('get_employee', 'ApiAppsController::getEmployee');
});
