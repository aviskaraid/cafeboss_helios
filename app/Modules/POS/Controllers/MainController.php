<?php

namespace Modules\POS\Controllers;

use App\Controllers\BaseController;

class MainController extends BaseController
{   
    private $module = 'POS'; // Module name

    public function index()
    {
        $business = business_detail();
        $jsonBusiness = json_encode($business);
        setcookie("business",$jsonBusiness);
        $prefix = setup_business("stores_prefixes")->stores_prefixes;
        setcookie("prefix",$prefix);
        $user = json_encode(session()->get('user_login'));
        setcookie('user', $user,0, "/");
        $data = [
            'title' => 'CafeBoss',
            ];
        return hmvcView($this->module, 'main', $data);
    }
}