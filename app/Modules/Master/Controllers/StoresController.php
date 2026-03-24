<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\StoresModel;

class StoresController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $warehouse = new StoresModel();
        $keyword = $this->request->getGet('keyword');
		$data = $warehouse->getPaginated(10, $keyword);
        $data['title'] = "Stores List";
        return hmvcView($this->module, 'stores_list', $data);
    }

    public function create(){
        $data['title'] = "New Stores"; 
        $data['generate_code'] = becko_stores_code(8,true); 
        return hmvcView($this->module, 'stores_create', $data);
    }

    public function create_process(){
        $stores = new StoresModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $post['business'] = 1;
        $message = "Successfully";
        $category = explode(",",$post['input_category']);
        $add_store =[
            "code"          =>  $post['code'],
            "name"          =>  $post['name'],
            "business_id"   => 1,
            "description"   =>  $post['description'],
            "address"       =>  $post['address'],
            "location"      =>  $post['location'],
            "remark"   =>  $post['remark'],
            "active"        => (int)$post['active']
        ];
        $save = $stores->save($add_store);
        if(!$save) {
            return error_response(json_encode($stores->errors()),400);
        }
        $storeID = $stores->getInsertID();
        $categoryID =[];
        foreach ($category as $item) {
            $set = [
                'store_id'      => $storeID,
                'category_id'   => $item
            ];
            array_push($categoryID,$set);
        }
        $stores->insertStoreCategoryMap($storeID,$categoryID);
        $store_setup = [
            "store_id"=>$storeID,
            "display_name" =>$post['description']
        ];
        $stores->insertSetup($store_setup);
        $data['food'] = $add_store;
        $data['redirect'] = "master/stores";
        return json_response($data,200,$message);
    }

    public function edit($id = null){
		
        $dataGet = new StoresModel();
        $where = ['id'=>$id];
        $nested = ["store_setup"=>"store_id"];
        $get = $dataGet->getFind($where,null,null,0,0,$nested)[0];
        $data['title'] = "Store Edit ".$get->description;
        $data['store'] = $get;
        $data['setup'] = $get->store_setup[0];
        //dd($data);
        return hmvcView($this->module, 'stores_edit', $data);
    }

    public function changes($id = null){
        $stores = new StoresModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $message = "Successfully";
        $category = explode(",",$post['input_category']);
         $add_store =[
            "code"          =>  $post['code'],
            "name"          =>  $post['name'],
            "business_id"   => 1,
            "description"   =>  $post['description'],
            "address"       =>  $post['address'],
            "location"      =>  $post['location'],
            "remark"        =>  $post['remark'],
            "active"        => (int)$post['active']
        ];
        $stores->update($post['store_id'],$add_store);
        
        $categoryID =[];
        foreach ($category as $item) {
            $set = [
                'store_id'      => $post['store_id'],
                'category_id'   => $item
            ];
            array_push($categoryID,$set);
        }
        $stores->insertStoreCategoryMap($post['store_id'],$categoryID);
        $store_setup = [
            "display_name"      =>$post['description'],
            "minimum_charge"    =>floatval($post['description']),
            "vat"               =>floatval($post['vat']),
            "dp"                => isset($post['dp']) ? 1 : 0,
            "lock_close"        => isset($post['lock_close']) ? 1 : 0,
            "merge_bill"        => isset($post['merge_bill']) ? 1 : 0,
            "split_bill"        => isset($post['split_bill']) ? 1 : 0,
            "void"              => isset($post['void']) ? 1 : 0,
            "take_away"         => isset($post['take_away']) ? 1 : 0,
            "updated_at"        =>date('Y-m-d H:i:s')
        ];
        $stores->edit_setup_change($post['store_id'],$store_setup);
        $data['food'] = $add_store;
        $data['redirect'] = "master/stores";
       // dd($data);
        return json_response($data,200,$message);

    }
}