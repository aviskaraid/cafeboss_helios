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
        $posTransactionPayment = new PosTransactionsPaymentsModel();
        $json = $this->request->getJSON();
        $timestamp = strtotime($json->start_time);
        $startTime = date('Y-m-d H:i:s', $timestamp);
        $transaction_id = null;
        if($json->transaction_id != null or $json->transaction_id != ""){
            $transaction_id = $json->transaction_id;
            $headers = [
                "pos_id"            =>$json->pos_id,
                "type"              =>"resto",
                "shift"             =>$json->shift,
                "store_id"          =>$json->store->id,
                "status"            =>"final",
                "sub_type"          =>'dine_in',
                "payment_method"    =>$json->payment->payMethod,
                "customer_id"       =>$json->customer->id,
                "table_id"          =>$json->table->id,
                "sequence"          =>getSequenceTransac($json->pos_id),
                "transaction_date"  =>$json->start_time,
                "ref_no"            =>$json->ref_no,
                "disc_type"         =>"percentage",
                "sub_total"         =>(float)$json->sub_total,
                "total"             =>(float)$json->total,
                "disc_amount"       =>(float)$json->discount
            ];
            $posTransaction->update($transaction_id,$headers);
            $payment = [
                "business_id"       =>$json->store->business_id,
                "amount"            =>$json->payment->amount,
                "method"            =>$json->payment->payMethod,
                "payment_type"      =>$json->payment->payMethod,
                "bank_account_number"   => $json->payment->account_name." : ".$json->payment->account_number,
                "transaction_no"        => ($json->payment->account_name=="")?"":$json->payment->account_trans_number,
                "paid_on"               => date('Y-m-d H:i:s'),
                "note"                  => "",
            ];
            $posTransactionPayment->where('transaction_id', $transaction_id);
            $posTransactionPayment->update(null,$payment);
            $lines = [];
            foreach ($json->items as $key) {
                $dataItem = [
                    'transaction_id'            => $transaction_id,
                    'foodmenu_id'               => $key->foodMenuId,
                    'quantity'                  => $key->qty,
                    'sub_total'                 => floatval($key->price)*floatval($key->qty),
                    'total'                     => floatval($key->price)*floatval($key->qty),
                    'price'                     => $key->price,
                ];
                // array_push($lines,$dataItem);
                $detailSave = new PosTransactionsLinesModel();
                $detailSave->where('transaction_id', $transaction_id);
                $detailSave->where('foodmenu_id', $key->foodMenuId);
                $detailSave->update(null,$dataItem);
            }
            $tbl = new TablesModel();
            $reservationName = ($json->customer->username=="general")?"General":$json->customer->fullname;
            $updates = ['reservation'=>0,'reservation_name'=>"",'transaction_id'=>0];
            $tbl->update($json->table->id,$updates);
            return $this->response->setJSON(['status' => 'success', 'message' => 'successfully','data'=>$transaction_id]);
        }else{
            $headers = [
                "pos_id"            =>$json->pos_id,
                "type"              =>"resto",
                "shift"             =>$json->shift,
                "store_id"          =>$json->store->id,
                "status"            =>($json->hold==true)?"hold":"final",
                "sub_type"          =>($json->hold==true)?'dine_in':'take_away',
                "payment_method"    =>$json->payment->payMethod,
                "customer_id"       =>$json->customer->id,
                "table_id"          =>$json->table->id,
                "start"             =>$startTime,
                "sequence"          =>($json->hold==true)?0:getSequenceTransac($json->pos_id),
                "transaction_date"  =>$json->start_time,
                "ref_no"            =>$json->ref_no,
                "disc_type"         =>"percentage",
                "sub_total"         =>(float)$json->sub_total,
                "total"             =>(float)$json->total,
                "disc_amount"       =>(float)$json->discount
            ];
            $posTransaction->save($headers);
            $transactionId = $posTransaction->getInsertID();
            $payment = [
                "transaction_id"    =>$transactionId,
                "business_id"       =>$json->store->business_id,
                "amount"            =>0,
                "method"            =>$json->payment->payMethod,
                "payment_type"      =>$json->payment->payMethod,
                "bank_account_number"   => $json->payment->account_name." : ".$json->payment->account_number,
                "transaction_no"        => ($json->payment->account_name=="")?"":$json->payment->account_trans_number,
                "paid_on"               => ($json->hold==true)?null:date('Y-m-d H:i:s'),
                "note"                  => "",
            ];
            $posTransactionPayment->save($payment);
            //$paymentId = $posTransacionPayment->getInsertID();
            $lines = [];
            foreach ($json->items as $key) {
                $dataItem = [
                    'transaction_id'            => $transactionId,
                    'foodmenu_id'               => $key->foodMenuId,
                    'quantity'                  => $key->qty,
                    'sub_total'                 => floatval($key->price)*floatval($key->qty),
                    'total'                     => floatval($key->price)*floatval($key->qty),
                    'price'                     => $key->price,
                ];
                array_push($lines,$dataItem);
            }
            $detailSave = new PosTransactionsLinesModel();
            $detailSave->insertBatch($lines);
            $tbl = new TablesModel();
            $reservationName = ($json->customer->username=="general")?"General":$json->customer->fullname;
            $updates = ['reservation'=>1,'reservation_name'=>$reservationName,'transaction_id'=>$transactionId];
            $tbl->update($json->table->id,$updates);
            return $this->response->setJSON(['status' => 'success', 'message' => 'successfully','data'=>$json]);
        }
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

    public function getProductsLines($id){
        $branch = new PosTransactionsLinesModel();
        $getProduct = $branch->getFoodMenuByLines($id);
        $data['product']    = $getProduct;
        return $this->response->setJSON($data);
       
    }
    public function getMemberLines($id){
        $branch = new PosTransactionsModel();
        $getProduct = $branch->getMemberByLines($id);
        $data['customer']    = $getProduct;
        return $this->response->setJSON($data);
       
    }
}