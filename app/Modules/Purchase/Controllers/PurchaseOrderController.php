<?php

namespace Modules\Purchase\Controllers;

use App\Controllers\BaseController;
use Modules\Purchase\Models\PurchaseOrderModel;

class PurchaseOrderController extends BaseController
{   
    private $module = 'Purchase'; // Module name

    public function index(){
        $purchaseorder = new PurchaseOrderModel();
        $keyword = $this->request->getGet('keyword');
		$data = $purchaseorder->getPaginated(10, $keyword);
        $data['title'] = "Purchase Order";
        return hmvcView($this->module, 'purchaseorder_list', $data);
    }

    public function create(){
        $data['generate_code'] = becko_purchase_order_code(8,true);
        // $data['transaction_date'] = date("Y-m-d H:i:s");
        $data['transaction_date'] = date("Y-m-d");
        $data['title'] = "Purchase Order New";
        return hmvcView($this->module, 'purchaseorder_create', $data);
    }
}