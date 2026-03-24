<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\UnitsModel;

class UnitsController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $units = new UnitsModel();
        $keyword = $this->request->getGet('keyword');
		$data = $units->getPaginated(10, $keyword);
        $data['title'] = "Units List";
        return hmvcView($this->module, 'units_list', $data);
    }
    public function create(){
        $data['title'] = "New Units"; 
        return hmvcView($this->module, 'units_create', $data);
    }
    public function create_process(){
        $units = new UnitsModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $save = $units->save($post);
        if($save) {
            $message = "successfully Inserted";
            $data['redirect'] = "master/warehouse";
            return json_response($data,200,$message);
        } else {
            $data['errors'] = $units->errors();
            return json_response($data, 400);
        }
    }
    
}