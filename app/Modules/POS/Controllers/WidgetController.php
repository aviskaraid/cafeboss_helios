<?php

namespace Modules\POS\Controllers;

use App\Controllers\BaseController;
use Modules\POS\Models\WidgetModel;

class WidgetController extends BaseController{   

    private $module = 'POS'; // Module name

    public function pending_transactions(){
        $json = $this->request->getJSON();
        $widget = new WidgetModel();
        $data = $widget->getTransactionPendingBranch($json->location_id,$json->status);
        return $this->response->setJSON(['status' => 'success', 'message' => 'data','data'=>$data]);
    }
   
}