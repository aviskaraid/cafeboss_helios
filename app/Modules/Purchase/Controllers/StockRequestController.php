<?php

namespace Modules\Purchase\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\DepartmentsModel;
use Modules\Master\Models\ItemsModel;
use Modules\Purchase\Models\StockRequestLinesModel;
use Modules\Purchase\Models\StockRequestModel;

class StockRequestController extends BaseController{   
    private $module = 'Purchase'; // Module name

    public function index(){
        $stockrequest = new StockRequestModel();
        $keyword = $this->request->getGet('keyword');
		$data = $stockrequest->getPaginated(10, $keyword);
        $data['title'] = "Stock Request";
        return hmvcView($this->module, 'stockrequest_list', $data);
    }

    public function create($id = null){
        $depart = new DepartmentsModel();
        $getDepartement = $depart->findAll();
         $data['generate_code'] = becko_stock_request_code(8,true);
        $data['title'] = "Stock Request New";
        $data['department'] = $getDepartement;
        //dd($data);
        return hmvcView($this->module, 'stockrequest_create', $data);
    }

    public function edit($id = null){
        $getData = new StockRequestModel();
        $where = ['id'=>$id];
        $get = $getData->getFind($where,null,null,0,0)[0];
        $data['title'] = "View Stock Request( ".$get->ref_no." )";
        $data['data'] = $get;
        //dd($data);
        return hmvcView($this->module, 'stockrequest_edit', $data);
    }

    public function create_process(){
        $post = $this->request->getJson(true);
        $dataArray = [];
        $trans_date = date("Y-m-d"); 
        $add_trans = [
            "ref_no"            => $post['ref_no'],
            "department_id"     => $post['input_department'],
            "transaction_date"  => $trans_date,
            "remark"            => $post['remark'],
            "requester_id"      => session()->get('user_login')->id,
            "created_by"        => session()->get('user_login')->id
        ];
        $SR = new StockRequestModel();
        $insert = $SR->save($add_trans);
        if(!$insert){
            $data['errors'] = $SR->errors();
            return json_response($data, 400);
        }
        foreach ($post as $key => $value) {
            // Cek apakah nama key mengandung kata 'qty'
            if (strpos($key, 'qty') !== false) {
                $qty_only[$key] = $value;
                preg_match('/\[(.*?)\]/', $key, $match);
                $innerContent = $match[1]; // Hasil: "1_2_0.00_0.00"
                $partItem = explode("_", $innerContent);
                $KeyWordItem = $partItem[0]."_".$partItem[1];
                $getItem = new ItemsModel();
                $bom = $getItem->getItemsDetailbyLocation($KeyWordItem);
                $itemId = $partItem[0];
                $warehouseID = $partItem[1];
                $parStock = $partItem[2];
                $stockOnhand = $partItem[3];
                $insertLnes['transaction_id'] = $SR->getInsertID();
                $insertLnes['item_id'] = $bom->item_id;
                $insertLnes['warehouse_id'] = $warehouseID;
                $insertLnes['stock_on_hand'] = $stockOnhand;
                $insertLnes['par_stock'] = $parStock;
                $insertLnes['request_stock'] = $value;
                array_push($dataArray,$insertLnes);
            }
        }
        $detail = new StockRequestLinesModel();
        $detail->insertBatch($dataArray);
        $message = "Successfully";
        $data['sr'] = $dataArray;
        $data['redirect'] = "purchase/stockrequest";
        return json_response($data,200,$message);
    }

    public function changes(){
        $post = $this->request->getPost();
        $trans_date = date("Y-m-d");
        $jumlah = $post['qty'];
        $dataArray = [];
        $id = $post['transaction_id'];
        $getSR = new StockRequestModel();
        $update_trans = [
            "ref_no"            => $post['ref_no'],
            "department_id"     => $post['input_department'],
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
         $detail = new StockRequestLinesModel();
        $detail->updateBatch($dataArray,'id');
        $message = "Successfully";
        //$data['sr'] = $dataArray;
        $data['redirect'] = "purchase/stockrequest";
        return json_response($data,200,$message);
    }
}