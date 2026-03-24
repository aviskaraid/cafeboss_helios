<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index()
    {
        // Example data to send to the view
        $data = [
            'title' => 'Welcome to Master module',
            'message' => 'This is an HMVC example in CodeIgniter 4'
        ];

        // Example of how to call a view with hmvcView
        // Syntax: hmvcView(string $module, string $view, array $data = [], array $options = [])
        //
        // $module: Name of the module (folder) where the view is located
        // $view: Name of the view file without the .php extension
        // $data: Associative array with the data to pass to the view (optional)
        // $options: Array of additional options for the view (optional)
        //
        // Usage example:
        //return hmvcView($this->module, 'index', $data, ['cache' => 300]);
        return hmvcView($this->module, 'user_list', $data);
    }
}