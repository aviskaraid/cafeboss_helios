<?php

namespace Modules\Purchase\Controllers;

use App\Controllers\BaseController;
use Modules\Purchase\Models\PurchaseGoodReceiveModel;

class PurchaseGoodReceiveController extends BaseController
{   
    private $module = 'Purchase'; // Module name

    public function index(){
        $purchaseGR = new PurchaseGoodReceiveModel();
        $keyword = $this->request->getGet('keyword');
		$data = $purchaseGR->getPaginated(10, $keyword);
        $data['title'] = "Purchase Good Receive";
        return hmvcView($this->module, 'purchasegoodreceive_list', $data);
    }
    public function create(){
        $data['generate_code'] = becko_purchase_goodreceive_code(8,true);
        $data['transaction_date'] = date("Y-m-d");
        $data['title'] = "Good Receive New";
        return hmvcView($this->module, 'purchasegoodreceive_create', $data);
    }
}