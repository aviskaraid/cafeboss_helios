<?php

// Define module routes
$routes->group('master', ['filter' => 'isLoggedIn','namespace' => 'Modules\Master\Controllers'], function($routes) {
    $routes->group('department',function ($routes) {
        $routes->get('/', 'DepartmentController::index');
        $routes->get('create', 'DepartmentController::create');
        // $routes->get('edit/(:any)', 'AccessController::edit/$1');
        // $routes->patch('changes/(:any)', 'AccessController::changes/$1');
        $routes->post('create_process','DepartmentController::create_process');
        $routes->get('generate_department_code','DepartmentController::generate_department_code');
    });

    $routes->group('warehouse',function ($routes) {
        $routes->get('/', 'WarehouseController::index');
        $routes->get('create', 'WarehouseController::create');
        // $routes->get('edit/(:any)', 'AccessController::edit/$1');
        // $routes->patch('changes/(:any)', 'AccessController::changes/$1');
        $routes->post('create_process','WarehouseController::create_process');
        $routes->get('generate_warehouse_code','WarehouseController::generate_warehouse_code');
    });

    $routes->group('units',function ($routes) {
        $routes->get('/', 'UnitsController::index');
        $routes->get('create', 'UnitsController::create');
        // $routes->get('edit/(:any)', 'AccessController::edit/$1');
        // $routes->patch('changes/(:any)', 'AccessController::changes/$1');
        $routes->post('create_process','UnitsController::create_process');
        $routes->get('generate_warehouse_code','UnitsController::generate_warehouse_code');
    });

    $routes->group('itemcategory',function ($routes) {
        $routes->get('/', 'ItemCategoryController::index');
        $routes->get('create', 'ItemCategoryController::create');
        // $routes->get('edit/(:any)', 'AccessController::edit/$1');
        // $routes->patch('changes/(:any)', 'AccessController::changes/$1');
        $routes->post('create_process','ItemCategoryController::create_process');
    });

    $routes->group('items',function ($routes) {
        $routes->get('/', 'ItemsController::index');
        $routes->get('create', 'ItemsController::create');
         $routes->get('generate_items_code','ItemsController::generate_itemsCode');
        // $routes->get('edit/(:any)', 'AccessController::edit/$1');
        // $routes->patch('changes/(:any)', 'AccessController::changes/$1');
        $routes->post('create_process','ItemsController::create_process');
        $routes->get('setup_units/(:any)','ItemsController::setup_units/$1');
        $routes->post('setup_units_process','ItemsController::setup_units_process');
    });

    $routes->group('foodmenucategory',function ($routes) {
        $routes->get('/', 'FoodMenuCategoryController::index');
        $routes->get('create', 'FoodMenuCategoryController::create');
         $routes->get('generate_items_code','FoodMenuCategoryController::generate_itemsCode');
        // $routes->get('edit/(:any)', 'AccessController::edit/$1');
        // $routes->patch('changes/(:any)', 'AccessController::changes/$1');
        $routes->post('create_process','FoodMenuCategoryController::create_process');
    });

    $routes->group('food_menu',function ($routes) {
        $routes->get('/', 'FoodMenuController::index');
        $routes->get('create', 'FoodMenuController::create');
        $routes->get('generate_foodmenu_code','FoodMenuController::generate_foodMenuCode');
        $routes->get('edit/(:any)', 'FoodMenuController::edit/$1');
        $routes->patch('changes/(:any)', 'FoodMenuController::changes/$1');
        $routes->post('create_process','FoodMenuController::create_process');
    });

    $routes->group('stores',function ($routes) {
        $routes->get('/', 'StoresController::index');
        $routes->get('create', 'StoresController::create');
        $routes->post('create_process','StoresController::create_process');
        $routes->get('edit/(:any)', 'StoresController::edit/$1');
        $routes->patch('changes/(:any)', 'StoresController::changes/$1');
        $routes->get('generate_stores_code','StoresController::generate_stores_code');
    });

    $routes->group('table',function ($routes) {
        $routes->get('/', 'TablesController::index');
        $routes->get('create', 'TablesController::create');
        $routes->post('create_process','TablesController::create_process');
        $routes->get('edit/(:any)', 'TablesController::edit/$1');
        $routes->patch('changes/(:any)', 'TablesController::changes/$1');
        $routes->get('generate_stores_code','TablesController::generate_stores_code');
        
        //area
        $routes->get('area', 'TablesController::area_list');
        $routes->get('area/create', 'TablesController::area_create');
        $routes->post('area/create_process','TablesController::area_create_process');
        $routes->get('area/edit/(:any)', 'TablesController::area_edit/$1');
        $routes->patch('area/changes/(:any)', 'TablesController::area_changes/$1');
    });

    $routes->group('employee_group',function ($routes) {
        $routes->get('/', 'EmployeeGroupController::index');
        $routes->get('create', 'EmployeeGroupController::create');
        $routes->post('create_process','EmployeeGroupController::create_process');
        $routes->get('generate_employeegroup_code','EmployeeGroupController::generate_employeegroup_code');
    });

    $routes->group('employees',function ($routes) {
        $routes->get('/', 'EmployeeController::index');
        $routes->get('create', 'EmployeeController::create');
        $routes->post('create_process','EmployeeController::create_process');
        $routes->get('generate_employee_code','EmployeeController::generate_employee_code');
    });
});
