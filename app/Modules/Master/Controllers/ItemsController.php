<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\ItemsModel;
use Modules\Master\Models\ItemUnitModel;

class ItemsController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $units = new ItemsModel();
        $keyword = $this->request->getGet('keyword');
		$data = $units->getPaginated(10, $keyword);
        $data['title'] = "Items List";
        return hmvcView($this->module, 'items_list', $data);
    }
    public function create(){
        $data['title'] = "Create Items";
        $data['generate_code'] = becko_items_code(8,true); 
        return hmvcView($this->module, 'items_create', $data);
    }
    public function generate_itemsCode(){
        $itemsCode = becko_items_code(8,true);
        $message = "successfully Generate User Code";
        $data['items_code'] = $itemsCode;
        return $this->respond($itemsCode);
    }
    public function create_process(){
        $items = new ItemsModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $message = "Successfully";
        $warehouse = explode(",",$post['input_warehouse']);
        $add_item =[
            "sku"           =>$post['sku'],
            "code"          =>$post['code'],
            "name"          =>$post['name'],
            "display_name"  =>$post['display_name'],
            "description"   =>$post['description'],
            "category_id"   =>$post['category_id'],
            "brand_id"      =>1,
            "ingredient"    => isset($post['ingredient']) ? 1 : 0,
            "premade"       => isset($post['premade']) ? 1 : 0,
            "enable_stock"  => isset($post['enable_stock']) ? 1 : 0,
            "active"        => (int)$post['active'],
            "purchase_unit" => (int)$post['purchase_unit'],
            "main_unit"     => (int)$post['main_unit'],
            "alert_qty"     => (float)$post['alert_qty'],
        ];
        $save = $items->save($add_item);
        if(!$save) {
            return error_response(json_encode($items->errors()),400);
        }
        $itemID = $items->getInsertID();
        $location =[];
        foreach ($warehouse as $item) {
            $set = [
                'item_id' => $itemID,
                'warehouse_id' => $item
            ];
            array_push($location,$set);
        }
        $price =[];
        foreach ($warehouse as $item) {
            $set = [
                'item_id'               => $itemID,
                'warehouse_id'          => $item,
                "purchase_price"        => 0,
                "purchase_price_tax"    => 0,
                "hpp"                   => 0,
                "sell_price"            => str_replace(".", "", $post['sell_price']),
                "sell_price_tax"        => str_replace(".", "", $post['sell_price']),
                "profit_percent"        => 0,
            ];
            array_push($price,$set);
        }
        $stock =[];
        foreach ($warehouse as $item) {
            $set = [
                'item_id'               => $itemID,
                'warehouse_id'          => $item,
                "stock_qty"             => 0,
            ];
            array_push($stock,$set);
        }
        $items->insertLocation($itemID,$location);
        $items->insertPrice($itemID,$price);
        $items->insertStock($itemID,$stock);
        $data['item'] = $add_item;
        $data['redirect'] = "master/items";
        return json_response($data,200,$message);
    }

    public function setup_units($id = null){
		$items= new ItemsModel();
        $itemUnit = new ItemUnitModel();
        $where = ['id'=>$id];
        $getItems = $items->getFind($where)[0];
        $data['title'] = "Setup Units ".$getItems->description;
        $data['items'] = $getItems;
        return hmvcView($this->module, 'items_units', $data);
	}
    public function setup_units_process(){
		$itemModel= new ItemsModel();
        $post = $this->request->getJSON(true);
        $items = [];
        $arr_items = [];
        foreach ($post as $key => $value) {
            if (strpos($key, 'item_id_') === 0) {
                $index = substr($key, strlen('item_id_'));
                $items[$index]['item_id'] = $value;
            } elseif (strpos($key, 'unit_source_') === 0) {
                $index = substr($key, strlen('unit_source_'));
                $items[$index]['unit_source'] = $value;
            }elseif (strpos($key, 'value_source_') === 0) {
                $index = substr($key, strlen('value_source_'));
                $items[$index]['value_source'] = $value;
            }elseif (strpos($key, 'unit_dest_') === 0) {
                $index = substr($key, strlen(string: 'unit_dest_'));
                $items[$index]['unit_dest'] = $value;
            }elseif (strpos($key, 'value_dest_') === 0) {
                $index = substr($key, strlen('value_dest_'));
                $items[$index]['value_dest'] = $value;
            }
            array_push($arr_items,$items);
        }
        $hasil = [];
        foreach ($items as $key => $value) {
            array_push($hasil,$value);
        }
        $data['item_id'] = $post['items_id'];
        $data['hasil'] = $hasil;
        $addUnits = $itemModel->insertItemsUnit($post['items_id'],$hasil);
        if(!$addUnits){
            $data['message'] = "Failed";
            return json_response($data,400,"Failed");    
        }else{
            $message = "successfully Inserted";
            $data['success'] = true;
            $data['redirect'] = "master/items";
            return json_response($data,200,$message);
        }
	}
}