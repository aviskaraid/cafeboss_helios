<?php

namespace Modules\TAKTIKAL\Controllers;

use App\Controllers\BaseController;
use Modules\TAKTIKAL\Models\TaktikalItemModel;
use Modules\TAKTIKAL\Models\TaktikalModel;

class TaktikalController extends BaseController
{   
    private $module = 'TAKTIKAL'; // Module name

    public function index()
    {
        // Example data to send to the view
        $units = new TaktikalModel();
        $keyword = $this->request->getGet('keyword');
		$data = $units->getPaginated(10, $keyword);
        $data['title'] = "Taktikal List";
        return hmvcView($this->module, 'taktikal_list', $data);
    }

    public function generate_code(){
        $itemsCode = becko_taktikal_code(8,true);
        return $this->respond($itemsCode);
    }
    public function create(){
        $data['title'] = "Create Taktikal";
        $data['generate_code'] = becko_taktikal_code(8,true); 
        return hmvcView($this->module, 'taktikal_create', $data);
    }

    public function edit($id = null){
        $getData = new TaktikalModel();
        $where = ['id'=>$id];
        $get = $getData->getFind($where,null,null,0,0)[0];
        $data['title'] = "View Taktikal ( ".$get->ref_no." )";
        $data['data'] = $get;
        //dd($data);
        return hmvcView($this->module, 'taktikal_edit', $data);
    }

    public function create_process(){
        $taktikal = new TaktikalModel();
        $taktikalItem = new TaktikalItemModel();
        
        $post = $this->request->getJSON(true);
        $add_data =[
            "ref_code"        =>  $post['code'],
            "ref_no"        =>  $post['ref_no'],
            "description"   =>  $post['description'],
            "detail"        =>  $post['detail'],
            "supplier_id"   =>  $post['input_supplier'],
            "start_time"    =>  $post['start_time'],
            "end_time"      =>  $post['end_time']
        ];
        $save = $taktikal->save($add_data);
        if(!$save) {
            return error_response(json_encode($taktikal->errors()),400);
        }
        $itemLines =[
            "transaction_id"        =>  $taktikal->getInsertID()
        ];
        $taktikalItem->save($itemLines);
        $data['redirect'] = "taktikal";
        $message = "Successfully";
        return json_response($data,200,$message);
    }
    public function changes(){
        $taktikal = new TaktikalModel();
        $taktikalItem = new TaktikalItemModel();
        
        $post = $this->request->getJSON(true);
        $updated_at =[
            "ref_code"      =>  $post['code'],
            "ref_no"        =>  $post['ref_no'],
            "description"   =>  $post['description'],
            "detail"        =>  $post['detail'],
            "supplier_id"   =>  $post['input_supplier'],
            "start_time"    =>  $post['start_time'],
            "end_time"      =>  $post['end_time']
        ];
        $save = $taktikal->update($post['taktikal_id'],$updated_at);
        if(!$save) {
            return error_response(json_encode($taktikal->errors()),400);
        }
        $data['redirect'] = "taktikal";
        $message = "Successfully";
        return json_response($data,200,$message);
    }
}