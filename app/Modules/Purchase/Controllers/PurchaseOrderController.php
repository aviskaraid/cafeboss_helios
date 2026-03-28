<?php

namespace Modules\Purchase\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\ItemsModel;
use Modules\Purchase\Models\PurchaseOrderLinesModel;
use Modules\Purchase\Models\PurchaseOrderModel;
use Modules\Purchase\Models\PurchaseRequestLinesModel;
use Modules\Purchase\Models\PurchaseRequestModel;

class PurchaseOrderController extends BaseController
{   
    private $module = 'Purchase'; // Module name

    public function index(){
        $purchaseorder = new PurchaseOrderModel();
        $keyword = $this->request->getGet('keyword');
		$data = $purchaseorder->getPaginated(10, $keyword);
        $data['title'] = "Purchase Order";
        //dd($data);
        return hmvcView($this->module, 'purchaseorder_list', $data);
    }

    public function create(){
        $data['generate_code'] = becko_purchase_order_code(8,true);
        $data['transaction_date'] = date("Y-m-d");
        $data['title'] = "Purchase Order New";
        return hmvcView($this->module, 'purchaseorder_create', $data);
    }
    public function create_process(){
        $post = $this->request->getPost();
        $trans_date = date("Y-m-d");
        $jumlah = $post['qty'];
        $price_detail = $post['pricedetail'];
        $dataArray = [];
        $updatePR = [];
        $ref_no = $post['ref_code'];
        if(!empty($post['ref_no'])){
            $ref_no = $post['ref_no'];
        }
        $dataPRRaw = json_decode($post['raw_pr'], true); 
        $taktikal_contract = 0;
        $type = "Reguler";
        if((int)$post['taktikal_status'] > 0){
            $type = "Taktikal";
            $taktikal_contract = $post['input_taktikal_contract'];
        }
        $add_trans = [
            "pr_id"             => $post['pr_id'],
            "transaction_date"  => $trans_date,
            "due_date"          => $post['due_date'],
            "delivery_date"     => $post['delivery_date'],
            "ref_code"          => $post['ref_code'],
            "ref_no"            => $ref_no,
            "type"              => $type,
            "supplier_id"       => $post['supplier'],
            "department_id"     => $dataPRRaw['department_id'],
            "amount"            => $post['total'],
            "remark"            => $post['remark'],
            "remark_delivery"   => $post['remark_delivery'],
            "status"            => "New",
            "status_payment"    => "Unpaid",
            "type_payment"      => "Cash",
            "subtotal"          => $post['sub_total'],
            "discount"          => $post['discount'],
            "delivery_charges"  => $post['delivery_charge'],
            "vat"               => $post['vat'],
            "vat_amount"        => (((float)$post['vat']/100)*((float)($post['sub_total']+(float)$post['delivery_charge'])-(float)$post['discount'])),
            "taktikal"          => $taktikal_contract,
            "raw_pr"            => $post['raw_pr'],
            "requester_id"      => session()->get('user_login')->id,
            "created_by"        => session()->get('user_login')->id
        ];      
        $po = new PurchaseOrderModel();
        $insert = $po->save($add_trans);
        $pr = new PurchaseRequestModel();
        $update = ['po_selected'=>1];
        $pr->update($post['pr_id'],$update);
        if(!$insert){
            $data['errors'] = $po->errors();
            return json_response($data, 400);
        }
        foreach ($jumlah as $key => $value) {
            $getItem = new ItemsModel();
            $partItem = explode("_", $key);
            $KeyWordItem = $partItem[1]."_".$partItem[2];
            $itemBom = $getItem->getItemsDetailbyLocation($KeyWordItem);
            $itemBom->use_stock = $value;
            $insertBom['transaction_id'] = $po->getInsertID();
            $insertBom['item_id'] = $itemBom->item_id;
            $insertBom['warehouse_id'] = $partItem[2];
            $insertBom['stock_on_hand'] = $partItem[4];
            $insertBom['par_stock'] = $partItem[3];
            $insertBom['purchase_stock'] = $value;
            $insertBom['pr_line_id'] = $partItem[0];
            $insertBom['price'] = $price_detail[$key];
            $insertBom['total_price'] = (float)$price_detail[$key] * (float)$value;
            $updateSelected['transaction_id'] = $post['pr_id'];
            $updateSelected['item_id'] = $itemBom->item_id;
            $updateSelected['id'] = $partItem[0];
            $updateSelected['selected'] = 1;
            array_push($dataArray,$insertBom);
            array_push($updatePR,$updateSelected);
            // $insertBom['transaction_id'] = "$pr->getInsertID()";
         }
        $detail = new PurchaseOrderLinesModel();
        $detail->insertBatch($dataArray);
        $updatePRLines = new PurchaseRequestLinesModel();
        $updatePRLines->updateCloseAndSelected($updatePR,1,0);
        $message = "Successfully";
        $data['purchase_order'] = $post;
        $data['add_trans'] = $add_trans;
        $data['add_detail'] = $dataArray;
        $data['updated_pr'] = $updatePR;
        $data['redirect'] = "purchase/purchaseorder";
        return json_response($data,200,$message);
    }
    public function edit($id = null){
        $getData = new PurchaseOrderModel();
        $where = ['purchase_order.id'=>$id];
        $column = [
            "purchase_order.*","a.ref_no as pr_no"
        ];
        $array_join = [
            [
            "from" => "purchase_request a",
            "field" => "a.id",
            "source" => "purchase_order.pr_id"
            ]
        ];
        $get = $getData->getFind($where,null,null,0,0,[],$array_join,$column)[0];
        $data['title'] = "View Purchase Order( ".$get->ref_no." )";
        $data['data'] = $get;
        //dd($data);
        return hmvcView($this->module, 'purchaseorder_edit', $data);
    }

    public function changes(){
        $post = $this->request->getPost();
        $trans_date = date("Y-m-d");
        $jumlah = $post['qty'];
        $price_detail = $post['pricedetail'];
        $dataArray = [];
        $id = $post['transaction_id'];
        $updatePO = new PurchaseOrderModel();
        $update_trans = [
            "pr_id"             => $post['pr_id'],
            "transaction_date"  => $trans_date,
            "due_date"          => $post['due_date'],
            "delivery_date"     => $post['delivery_date'],
            "amount"            => $post['total'],
            "remark"            => $post['remark'],
            "remark_delivery"   => $post['remark_delivery'],
            "subtotal"          => $post['sub_total'],
            "discount"          => $post['discount'],
            "delivery_charges"  => $post['delivery_charge'],
            "vat"               => $post['vat'],
            "vat_amount"        => (((float)$post['vat']/100)*((float)($post['sub_total']+(float)$post['delivery_charge'])-(float)$post['discount'])),
        ];
        $updated = $updatePO->update($id,$update_trans);
        if(!$updated){
            $data['errors'] = $updatePO->errors();
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
            $insertBom['purchase_stock'] = $value;
            $insertBom['price'] = $price_detail[$key];
            $insertBom['total_price'] = (float)$price_detail[$key] * (float)$value;
            array_push($dataArray,$insertBom);
         }
        $detail = new PurchaseOrderLinesModel();
        $detail->updateBatch($dataArray,'id');
        $getsDeleted = $detail->UpdateLines($id);
        if($getsDeleted != null){
            $detail->delete($getsDeleted->id);
        }
        $message = "Successfully";
        //$data['sr'] = $gets;
        $data['redirect'] = "purchase/purchaseorder";
        return json_response($data,200,$message);
    }
}