<?php

namespace Modules\Purchase\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\ItemsModel;
use Modules\Purchase\Models\PurchaseRequestLinesModel;
use Modules\Purchase\Models\PurchaseRequestModel;
use Modules\Purchase\Models\StockRequestLinesModel;
use Modules\Purchase\Models\StockRequestModel;

class PurchaseRequestController extends BaseController{   
    private $module = 'Purchase'; // Module name

    public function index(){
        $purchaserequest = new PurchaseRequestModel();
        $keyword = $this->request->getGet('keyword');
		$data = $purchaserequest->getPaginated(10, $keyword);
        $data['title'] = "Purchase Request";
        //dd($data);
        return hmvcView($this->module, 'purchaserequest_list', $data);
    }
    public function create(){
        $data['generate_code'] = becko_purchase_request_code(8,true);
        $data['title'] = "Purchase Request New";
        return hmvcView($this->module, 'purchaserequest_create', $data);
    }
    public function edit($id = null){
        $getData = new PurchaseRequestModel();
        $where = ['purchase_request.id'=>$id];
        $column = [
            "purchase_request.*","a.ref_no as request_ref_no"
        ];
        $array_join = [
            [
            "from" => "stock_request a",
            "field" => "a.id",
            "source" => "purchase_request.request_id"
            ]
        ];
        $get = $getData->getFind($where,null,null,0,0,[],$array_join,$column)[0];
        $data['title'] = "View Purchase Request( ".$get->ref_no." )";
        $data['data'] = $get;
        return hmvcView($this->module, 'purchaserequest_edit', $data);
    }


    public function create_process(){
        $post = $this->request->getPost();
        $trans_date = date("Y-m-d");
        $jumlah = $post['qty'];
        $dataArray = [];
        $updateSR = [];
        $ref_no = $post['ref_code'];
        if(!empty($post['ref_no'])){
            $ref_no = $post['ref_no'];
        }
        $dataSRRaw = json_decode($post['sr_raw'], true); 
        $add_trans = [
            "ref_code"          => $post['ref_code'],
            "ref_no"            => $ref_no,
            "request_id"        => $post['request_id'],
            "department_id"     => $dataSRRaw['department_id'],
            "transaction_date"  => $trans_date,
            "remark"            => $post['remark'],
            "status"            => "Draft",
            "requester_id"      => session()->get('user_login')->id,
            "created_by"        => session()->get('user_login')->id
        ];
        $pr = new PurchaseRequestModel();
        $insert = $pr->save($add_trans);
        $sr = new StockRequestModel();
        $update = ['pr_selected'=>1];
        $sr->update($post['request_id'],$update);
        if(!$insert){
            $data['errors'] = $pr->errors();
            return json_response($data, 400);
        }
        foreach ($jumlah as $key => $value) {
            $getItem = new ItemsModel();
            $partItem = explode("_", $key);
            $KeyWordItem = $partItem[1]."_".$partItem[2];
            $itemBom = $getItem->getItemsDetailbyLocation($KeyWordItem);
            $itemBom->use_stock = $value;
            $insertBom['transaction_id'] = $pr->getInsertID();
            $insertBom['item_id'] = $itemBom->item_id;
            $insertBom['warehouse_id'] = $partItem[2];
            $insertBom['stock_on_hand'] = $partItem[4];
            $insertBom['par_stock'] = $partItem[3];
            $insertBom['request_stock'] = $value;
            $insertBom['sr_line_id'] = $partItem[0];
            $updateSelected['transaction_id'] = $post['request_id'];
            $updateSelected['item_id'] = $itemBom->item_id;
            $updateSelected['id'] = $partItem[0];
            $updateSelected['selected'] = 1;
            array_push($dataArray,$insertBom);
            array_push($updateSR,$updateSelected);
         }
        $detail = new PurchaseRequestLinesModel();
        $detail->insertBatch($dataArray);
        $updateSRLines = new StockRequestLinesModel();
        $updateSRLines->updateCloseAndSelected($updateSR,1,0);
        $message = "Successfully";
        $data['purchase_request'] = $post;
        $data['redirect'] = "purchase/purchaserequest";
        return json_response($data,200,$message);
    }

    public function changes(){
        $post = $this->request->getPost();
        $trans_date = date("Y-m-d");
        $jumlah = $post['qty'];
        $dataArray = [];
        $id = $post['transaction_id'];
        $getSR = new PurchaseRequestModel();
        $update_trans = [
            "ref_no"            => $post['ref_no'],
            "request_id"        => $post['request_id'],
            "transaction_date"  => $trans_date,
            "remark"            => $post['remark']
        ];
        $updated = $getSR->update($id,$update_trans);
        if(!$updated){
            $data['errors'] = $getSR->errors();
            return json_response($data, 400);
        }
        foreach ($jumlah as $key => $value) {
             $getItem = new ItemsModel();
             $partItem = explode("_", $key);
             $KeyWordItem = $partItem[1]."_".$partItem[2];
             $itemBom = $getItem->getItemsDetailbyLocation($KeyWordItem);
             $itemBom->use_stock = $value;
             $insertBom['id'] = $partItem[0];
             $insertBom['transaction_id'] = $id;
             $insertBom['item_id'] = $itemBom->item_id;
             $insertBom['warehouse_id'] = $partItem[2];
             $insertBom['stock_on_hand'] = $partItem[4];
             $insertBom['par_stock'] = $partItem[3];
             $insertBom['request_stock'] = $value;
             array_push($dataArray,$insertBom);
         }
        $detail = new PurchaseRequestLinesModel();
        $detail->updateBatch($dataArray,'id');
        $getsDeleted = $detail->UpdateLines($id);
        if($getsDeleted != null){
            $detail->delete($getsDeleted->id);
        }
        $message = "Successfully";
        //$data['sr'] = $gets;
        $data['redirect'] = "purchase/purchaserequest";
        return json_response($data,200,$message);
    }
    
}