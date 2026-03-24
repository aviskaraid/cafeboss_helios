<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\SupplierModel;

class SupplierController extends BaseController
{   
     private $module = 'Master'; // Module name

    public function index(){
        $supplier = new SupplierModel();
        $keyword = $this->request->getGet('keyword');
		$data = $supplier->getPaginated(10, $keyword);
        $data['title'] = "Supplier List";
        return hmvcView($this->module, 'supplier_list', $data);
    }

    public function create(){
        $data['title'] = "New Supplier"; 
        $data['generate_code'] = becko_supplier_code(8,true); 
        return hmvcView($this->module, 'supplier_create', $data);
    }

    public function generate_supplier_code(){
        $code = becko_supplier_code(8,true);
        $message = "successfully Generate Supplier Code";
        $data['supplier_code'] = $code;
        return $this->respond($code);
    }
    public function create_process(){
        $supplier = new SupplierModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $post['business'] = 1;
        $message = "Successfully";
        $add_data =[
            "ref_code"      =>  $post['code'],
            "name"          =>  $post['name'],
            "business_id"   => 1,
            "description"   =>  $post['description'],
            "address"       =>  $post['address'],
            "phone_number"  =>  $post['phone_number'],
            "contact"       =>  $post['contact_name'],
            "location"      =>  $post['location'],
            "remark"        =>  $post['remark'],
            "active"        => (int)$post['active']
        ];
        $save = $supplier->save($add_data);
        if(!$save) {
            return error_response(json_encode($supplier->errors()),400);
        }
        
        $data['supplier'] = $add_data;
        $data['redirect'] = "master/supplier";
        return json_response($data,200,$message);
    }
    public function edit($id = null){
        $dataGet = new SupplierModel();
        $where = ['id'=>$id];
        // $nested = ["store_setup"=>"store_id"];
        $get = $dataGet->getFind($where,null,null,0,0,[])[0];
        $data['title'] = "Supplier Edit ".$get->name;
        $data['data'] = $get;
        return hmvcView($this->module, 'supplier_edit', $data);
    }

    public function changes($id = null){
        $stores = new SupplierModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $message = "Successfully";
        $update_data =[
            "ref_code"      =>  $post['code'],
            "name"          =>  $post['name'],
            "business_id"   => 1,
            "phone_number"  =>  $post['phone_number'],
            "contact"       =>  $post['contact_name'],
            "description"   =>  $post['description'],
            "address"       =>  $post['address'],
            "location"      =>  $post['location'],
            "remark"        =>  $post['remark'],
            "active"        => (int)$post['active']
        ];
        $stores->update($post['supplier_id'],$update_data);
        $data['supplier'] = $update_data;
        $data['redirect'] = "master/supplier";
       // dd($data);
        return json_response($data,200,$message);

    }
}