<?php

namespace Modules\RND\Controllers;

use App\Controllers\BaseController;
use Modules\RND\Models\RNDModel;

class RNDController extends BaseController
{   
    private $module = 'RND'; // Module name

    public function index(){
        $dataList = new RNDModel();
        $keyword = $this->request->getGet('keyword');
		$data = $dataList->getPaginated(10, $keyword);
        $data['title'] = "R & D List";
        return hmvcView($this->module, 'rnd_list', $data);
    }

    public function create(){
        $rnd = new RNDModel();
        $getId = $rnd->countAllResults()+1;
        $data['title'] = "Create New R & D";
        $data['id'] = $getId;
        $data['generate_code'] = becko_rnd_code(8,true);
        return hmvcView($this->module, 'rnd_create', $data);
    }

    public function edit($id = null){
        $rnd = new RNDModel();
        $where = ["id"=>$id];
        $getRND = $rnd->getFind($where)[0];
        $data['title'] = "Edit RND Menu ".$getRND->description;
        $data['rnd'] = $getRND;
        return hmvcView($this->module, 'rnd_edit', $data);
    }

    public function generate_rnd_code(){
        $code = becko_rnd_code(8,true);
        $message = "successfully Generate RND Code";
        $data['user_code'] = $code;
        return $this->respond($code);
    }

    public function create_process(){
		$rnd= new RNDModel();
        $post = $this->request->getJSON(true);
        $items = [];
        $arr_items = [];
        foreach ($post as $key => $value) {
            if (strpos($key, 'rnd_id_') === 0) {
                $index = substr($key, strlen('rnd_id_'));
                $items[$index]['rnd_id'] = $value;
            } elseif (strpos($key, 'item_id_') === 0) {
                $index = substr($key, strlen('item_id_'));
                $items[$index]['item_id'] = $value;
            }elseif (strpos($key, 'consumption_') === 0) {
                $index = substr($key, strlen('consumption_'));
                $items[$index]['consumption'] = $value;
            }elseif (strpos($key, 'price_') === 0) {
                $index = substr($key, strlen(string: 'price_'));
                $items[$index]['price'] = $value;
            }elseif (strpos($key, 'total_') === 0) {
                $index = substr($key, strlen('total_'));
                $items[$index]['total'] = $value;
            }
            array_push($arr_items,$items);
        }
        $hasil = [];
        foreach ($items as $key => $value) {
            array_push($hasil,$value);
        }
        $header = [
            "transaction_date"  =>date('Y-m-d H:i:s'),
            "business_id"       =>1,
            "description"       =>$post['description'],
            "remark"            =>$post['remark'],
            "code"              =>$post['code'],
            "status"            =>"rnd",
            "sub_status"        =>"draft",
            "employee_id"       =>$post['input_employee'],
            "hpp"               =>0,
            "total"             =>0
        ];
       
        $message = "Successfully";
        $data['header']         = $header;
        $save = $rnd->save($header);
        if(!$save) {
            return error_response(json_encode($rnd->errors()),400);
        }
        $itemID = $rnd->getInsertID();
        $ingredients = [];
        $hpp = 0;
        $total = 0;
        foreach ($hasil as $key) {
            $dt['rnd_id'] = $itemID;
            $dt['item_id'] = $key['item_id'];
            $dt['consumption'] = $key['consumption'];
            $dt['cost'] = str_replace(".", "", $key['price']);
            $dt['total'] = str_replace(".", "", $key['total']);
            $dt['active'] = 1;
            $hpp += floatval(str_replace(".", "", $key['total']));
            $total += floatval(str_replace(".", "", $key['total']));
            array_push($ingredients,$dt);
        }
        $rnd->insertRNDIngredient($itemID,$ingredients);
        $row = [
            "hpp"=>$hpp,
            "total"=>$total
        ];
        $rnd->update($itemID,$row);
        $data['ingredients'] = $ingredients;
        $data['redirect'] = "rnd";
        return json_response($data,200,$message);
    }

    public function changes($id = null){
		$rnd= new RNDModel();
        $post = $this->request->getJSON(true);
        $items = [];
        $arr_items = [];
        foreach ($post as $key => $value) {
            if (strpos($key, 'rnd_id_') === 0) {
                $index = substr($key, strlen('rnd_id_'));
                $items[$index]['rnd_id'] = $value;
            } elseif (strpos($key, 'item_id_') === 0) {
                $index = substr($key, strlen('item_id_'));
                $items[$index]['item_id'] = $value;
            }elseif (strpos($key, 'consumption_') === 0) {
                $index = substr($key, strlen('consumption_'));
                $items[$index]['consumption'] = $value;
            }elseif (strpos($key, 'price_') === 0) {
                $index = substr($key, strlen(string: 'price_'));
                $items[$index]['price'] = $value;
            }elseif (strpos($key, 'total_') === 0) {
                $index = substr($key, strlen('total_'));
                $items[$index]['total'] = $value;
            }
            array_push($arr_items,$items);
        }
        $hasil = [];
        foreach ($items as $key => $value) {
            array_push($hasil,$value);
        }
        $header = [
            "transaction_date"  =>date('Y-m-d H:i:s'),
            "business_id"       =>1,
            "description"       =>$post['description'],
            "remark"            =>$post['remark'],
            "code"              =>$post['code'],
            "status"            =>"rnd",
            "sub_status"        =>"draft",
            "employee_id"       =>$post['input_employee'],
            "hpp"               =>0,
            "total"             =>0
        ];
       
        $message = "Successfully";
        $data['header']         = $header;
        $rnd->update($post['rnd_id'],$header);
        $ingredients = [];
        $hpp = 0;
        $total = 0;
        foreach ($hasil as $key) {
            $dt['rnd_id'] = $post['rnd_id'];
            $dt['item_id'] = $key['item_id'];
            $dt['consumption'] = $key['consumption'];
            $dt['cost'] = str_replace(".", "", $key['price']);
            $dt['total'] = str_replace(".", "", $key['total']);
            $dt['active'] = 1;
            $hpp += floatval(str_replace(".", "", $key['total']));
            $total += floatval(str_replace(".", "", $key['total']));
            array_push($ingredients,$dt);
        }
        $rnd->insertRNDIngredient($post['rnd_id'],$ingredients);
        $row = [
            "hpp"=>$hpp,
            "total"=>$total
        ];
        $rnd->update($post['rnd_id'],$row);
        $data['ingredients'] = $ingredients;
        $data['redirect'] = "rnd";
        return json_response($data,200,$message);
    }

}