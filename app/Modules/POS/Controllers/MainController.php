<?php

namespace Modules\POS\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\StoresModel;
use Modules\Master\Models\UsersModel;
use Modules\POS\Models\PosModel;
class MainController extends BaseController
{   
    private $module = 'POS'; // Module name

    public function index()
    {
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
        return hmvcView($this->module, 'main', $data);
    }
    // test deploy
    public function check_openShift(){
        $json = $this->request->getJSON();
        if($json){
                $pos = new PosModel();
                $where = ["id"=>$json->store_id->id,"status"=>"open"];
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
        $json = $this->request->getJSON();
        return $this->response->setJSON(['status' => 'success', 'message' => 'data Tidak ada','data'=>$json]);
        
    }
}