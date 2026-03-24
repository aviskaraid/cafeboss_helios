<?php

// Define module routes
$routes->group('settings', ['filter' => 'isLoggedIn','namespace' => 'Modules\Setup\Controllers'], function($routes) {
    $routes->group('mainmenu', function ($routes) {
        $routes->get('/', 'MainMenuController::index');
        $routes->get('create', 'MainMenuController::create');
        $routes->get('edit/(:any)', 'MainMenuController::edit/$1');
        $routes->patch('changes/(:any)', 'MainMenuController::changes/$1');
        $routes->post('create_process','MainMenuController::create_process');
    });
    $routes->group('accessmenu',function ($routes) {
        $routes->get('/', 'AccessController::index');
        $routes->get('create', 'AccessController::create');
        $routes->get('edit/(:any)', 'AccessController::edit/$1');
        $routes->patch('changes/(:any)', 'AccessController::changes/$1');
        $routes->post('create_process','AccessController::create_process');
    });
    $routes->group('user_groups', ['namespace' => 'Modules\Setup\Controllers'], function($routes) {
        $routes->get('/', 'UserGroupsController::index');
        $routes->get('create', 'UserGroupsController::create');
        $routes->get('edit/(:any)', 'UserGroupsController::edit/$1');
        $routes->patch('changes/(:any)', 'UserGroupsController::changes/$1');
        $routes->post('create_process','UserGroupsController::create_process');

        // access groups
        $routes->get('access/(:any)','UserGroupsController::access_edit/$1');
        $routes->patch('access_changes/(:any)', 'UserGroupsController::access_changes/$1');
    });

    $routes->group('apps', ['namespace' => 'Modules\Setup\Controllers'], function($routes) {
        $routes->get('/', 'AppsController::setup');
        $routes->post('save_process', 'AppsController::save_process');
    });
    $routes->group('users', function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->post('upload_image', 'UserController::upload_image');
        $routes->get('create', 'UserController::create');


        $routes->get('generate_user_code','UserController::generate_userCode');
       // $routes->get('edit/(:any)', 'MainMenuController::edit/$1');
        //$routes->patch('changes/(:any)', 'MainMenuController::changes/$1');
        $routes->post('create_process','UserController::create_process');
    });
});


