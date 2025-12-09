<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\WarehouseModel;

class WarehouseController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $warehouse = new WarehouseModel();
        $keyword = $this->request->getGet('keyword');
		$data = $warehouse->getPaginated(10, $keyword);
        $data['title'] = "Warehouse List";
        return hmvcView($this->module, 'warehouse_list', $data);
    }

    public function create(){
        $data['title'] = "New Warehouse"; 
        $data['generate_code'] = becko_warehouse_code(8,true); 
        return hmvcView($this->module, 'warehouse_create', $data);
    }
    public function generate_warehouse_code(){
        $code = becko_warehouse_code(8,true);
        $message = "successfully Generate Warehouse Code";
        $data['user_code'] = $code;
        return $this->respond($code);
    }
    public function create_process(){
        $warehouse = new WarehouseModel();
        $post = $this->request->getJSON(true);
        $post['business_id'] = 1;
        $post['active'] = 1;
        $save = $warehouse->save($post);
        if($save) {
            $message = "successfully Inserted";
            $data['redirect'] = "master/warehouse";
            return json_response($data,200,$message);
        } else {
            $data['errors'] = $warehouse->errors();
            return json_response($data, 400);
        }
    }
}