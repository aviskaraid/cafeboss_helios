<?php

namespace Modules\Beranda\Controllers;

use App\Controllers\BaseController;
use Modules\API\Models\AppsModel;

class BerandaController extends BaseController
{   
    private $module = 'Beranda'; // Module name

    public function index()
    {
        $data = [];
        $getMenu = new AppsModel();
      //  dd($getMenu->getAccessUserMenu(1));
        return hmvcView($this->module, 'beranda', $data);
    }
}