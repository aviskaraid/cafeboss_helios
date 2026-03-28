<?php

namespace Modules\POS\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\FoodMenuCategoryModel;
use Modules\Master\Models\FoodMenuModel;
use Modules\Master\Models\StoresModel;
use Modules\Master\Models\TablesModel;
use Modules\Master\Models\UsersModel;
use Modules\POS\Models\PosModel;
use Modules\POS\Models\PosTransactionsLinesModel;
use Modules\POS\Models\PosTransactionsModel;
use Modules\POS\Models\PosTransactionsPaymentsModel;

class MainController extends BaseController
{   
    private $module = 'POS'; // Module name
    #edit pos
    public function index(){
        $business = business_detail();
        $jsonBusiness = json_encode($business);
        setcookie("business",$jsonBusiness);
        $prefix = setup_business("stores_prefixes")->stores_prefixes;
        $server = apps("server_url")->server_url;
        setcookie("prefix",$prefix);
        setcookie("server",$server);
        $userModel = new UsersModel();
        $whreUser = ['id'=>session()->get("user_login")->id];
        $getUser = $userModel->getFind($whreUser)[0];
        //dd(json_encode($getUser,JSON_PRETTY_PRINT));
        setcookie('user', json_encode($getUser),0, "/");
        $data = [
            'title' => 'CafeBoss',
            ];
        return hmvcView($this->module, 'main_dashboard', $data);
    }
    public function indexpos(){
        $userModel = new UsersModel();
        $whreUser = ['id'=>session()->get("user_login")->id];
        $getUser = $userModel->getFind($whreUser)[0];
        //dd(json_encode($getUser,JSON_PRETTY_PRINT));
        setcookie('user', json_encode($getUser),0, "/");
        $data = [
            'title' => 'CafeBoss',
            ];
        return hmvcView($this->module, 'main', $data);
    }
    // test deploy
    public function check_openShift(){
        $json = $this->request->getJSON();
        if($json){
                $pos = new PosModel();
                $where = ["store_id"=>$json->store_id->id,"status"=>"open"];
                $getExist = $pos->getFind(null,$where);
                $stores = new StoresModel();
                if($getExist!=null){
                    $dataS = $getExist[0];
                    $wStores = ['id'=>$dataS->store_id];
                    $setupNested = ["store_setup"=>"store_id"];
                    $getStores= $stores->getFind($wStores,null,null,0,0,$setupNested);
                    $dataS->store = $getStores[0];
                    return $this->response->setJSON(['status' => 'success', 'message' => "Data is Exist",'data'=>$dataS]);
                } else {
                return $this->response->setJSON(['status' => 'success', 'message' => 'data Tidak ada','data'=>null]);
            }
        }else{
            return $this->response->setJSON(['status' => 'error', 'message' => 'data Tidak ada']);
        }
    }

    public function start_shift(){
        $json = $this->request->getJSON();
        if($json){
            $user = get_user(session()->get('user_login')->id);
            //$user = get_user(1);
            $add_shift = [
                "business_id"           => $json->business_id,
                "store_id"              => intval($json->store_id),
                "user_id"               => $user->id,
                "status"                => "open",
                "shift"                 => intval($json->shift),
                "open_at"               => date('Y-m-d H:i:s'),
                "opening_amount"        => $json->opening_amount,
                "session_pos"           => $json->session_pos
            ];
            $pos = new PosModel();
            $where = ["user_id"=>$user->id,"store_id"=>$json->store_id,"shift"=>intval($json->shift)];
            $getExist = $pos->getFind(null,$where);
            if($getExist!=null){
                return $this->response->setJSON(['status' => 'exist', 'message' => "Data is Exist"]);
            }else{
                $insert = $pos->save($add_shift);
                if($insert){
                    return $this->response->setJSON(['status' => 'add', 'message' => "Successfully Add"]);
                }else{
                    return $this->response->setJSON(['status' => 'error', 'message' => "Failed Add"]);
                }
            }
           
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No JSON data received']);
        }
        // $post = $this->request->getPost();
        // $user_id = "user_preference";
        // $cookie_value = "dark_mode";
        // $expiration_time = time() + (86400 * 1); // Cookie expires in 1 days
        //setcookie($cookie_name, $cookie_value, $expiration_time, "/");
    }

    public function inputTransaction(){
        $posTransaction = new PosTransactionsModel();
        $posTransacionPayment = new PosTransactionsPaymentsModel();
        $json = $this->request->getJSON();
        $headers = [
            "pos_id"            =>$json->pos_id,
            "type"              =>"resto",
            "shift"             =>$json->shift,
            "sub_type"          =>($json->hold==true)?'dine_in':'take_away',
            "payment_method"    =>$json->payment->payMethod,
            "customer_id"       =>$json->customer->id,
            "table_id"          =>$json->table->id,
            "sequence"          =>($json->hold==true)?0:getSequenceTransac($json->pos_id),
            "transaction_date"  =>$json->start_time,
            "ref_no"            =>$json->ref_no,
            "disc_type"         =>"percentage",
            "disc_amount"       =>$json->discount,
        ];
        $posTransaction->save($headers);
        $salesId = $posTransaction->getInsertID();
        $payment = [
            "transaction_id"    =>$salesId,
            "business_id"       =>$json->store->business_id,
            "amount"            =>$json->payment->amount,
            "method"            =>$json->payment->payMethod,
            "payment_type"      =>$json->payment->payMethod,
            "bank_account_number"   => $json->payment->account_name." : ".$json->payment->account_number,
            "transaction_no"        => ($json->payment->account_name=="")?"":$json->payment->account_trans_number,
            "paid_on"               => ($json->hold==true)?null:date('Y-m-d H:i:s'),
            "note"                  => "",
        ];
        $posTransacionPayment->save($headers);
        $paymentId = $posTransacionPayment->getInsertID();
        $lines = [];
        foreach ($json->items as $key) {
            $dataItem = [
                'transaction_id'            => $salesId,
                'foodmenu_id'               => $key->foodmenuId,
                'quantity'                  => $key->qty,
                'sub_total'                 => floatval($key->price)*floatval($key->qty),
                'total'                     => floatval($key->price)*floatval($key->qty),
                'price'                     => $key->price,
            ];
            array_push($lines,$dataItem);
        }
        $detailSave = new PosTransactionsLinesModel();
        $detailSave->insertBatch($lines);
        //$updatesTable = ['reservation'=>1,'reservation_name'=>$reservationName,'transaction_id'=>$transactionId];
        //$tbl = new TablesModel();
        //$tbl->update($json->table->id,$updatesTable);
        return $this->response->setJSON(['status' => 'success', 'message' => 'successfully','data'=>$json]);
        
    }

    public function getProducts($id){
        $branch = new StoresModel();
        $whreBranch = ['id'=>$id];
        $getBranch = $branch->getFind($whreBranch)[0];
        $posModel = new PosModel();
        // $CatWHere = ["category.active"=>1,"groups.name"=>"restaurant"];
        $getCat = $posModel->getFoodMenuCategorybyStore($id);
        $getMenu = $posModel->getFoodMenu($id);
        $data['store']     = $getBranch;
        $data['category']   = $getCat;
        $data['product']    = $getMenu;
        return $this->response->setJSON($data);
       
    }
}