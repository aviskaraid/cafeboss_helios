<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\API\Models\AppsModel;
use Modules\Master\Models\FoodMenuCategoryModel;
use Modules\Master\Models\FoodMenuModel;

class FoodMenuController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
       $units = new FoodMenuModel();
        $keyword = $this->request->getGet('keyword');
		$data = $units->getPaginated(10, $keyword);
        $data['title'] = "Food Menu List";
        return hmvcView($this->module, 'foodmenu_list', $data);
    }


    public function generate_foodMenuCode(){
        $itemsCode = becko_foodmenu_code(8,true);
        $message = "successfully Generate Food Menu Code";
        $data['items_code'] = $itemsCode;
        return $this->respond($itemsCode);
    }
    public function create(){
		$data['title'] = "Food Menu";
        $data['generate_code'] = becko_foodmenu_code(8,true); 
        return hmvcView($this->module, 'foodmenu_create', $data);
    }

    public function create_process(){
        $foodMenu = new FoodMenuModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $message = "Successfully";
        $category = explode(",",$post['input_category']);
        $add_foodmenu =[
            "code"          =>$post['code'],
            "name"          =>$post['name'],
            "display_name"  =>$post['display_name'],
            "description"   =>$post['description'],
            "as_modifiers"  => isset($post['modifiers']) ? 1 : 0,
            "premade"       => isset($post['premade']) ? 1 : 0,
            "enable_stock"  => isset($post['enable_stock']) ? 1 : 0,
            "active"        => (int)$post['active'],
            "sell_price"    => floatval(str_replace(".", "", $post['sell_price'])),
            "alert_qty"     => (float)$post['alert_qty'],
        ];
        $save = $foodMenu->save($add_foodmenu);
        if(!$save) {
            return error_response(json_encode($foodMenu->errors()),400);
        }
        $itemID = $foodMenu->getInsertID();
        $categoryID =[];
        foreach ($category as $item) {
            $set = [
                'foodmenu_id' => $itemID,
                'category_id' => $item
            ];
            array_push($categoryID,$set);
        }
        $foodMenu->insertFoodMenuCategoryMap($itemID,$categoryID);
        $data['food'] = $add_foodmenu;
        $data['redirect'] = "master/food_menu";
        return json_response($data,200,$message);
    }

    public function edit($id = null){
		$data['title'] = "Food Menu";
        $menu = new FoodMenuModel();
        $where = ['id'=>$id];
        $getMenu = $menu->getFind($where)[0];
        $data['title'] = "Edit Food Menu ".$getMenu->description;
        $data['foodmenu'] = $getMenu;
        $apis = new AppsModel();
        $getCat = $apis->getFoodMenuCategoryByFoodMenu($id);
        $data['cata'] = $getCat;
        //dd($data);
        return hmvcView($this->module, 'foodmenu_edit', $data);
    }

    public function changes($id = null){
        $foodMenu = new FoodMenuModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $message = "Successfully";
        $category = explode(",",$post['input_category']);
        $edit_foodmenu =[
            "code"          =>$post['code'],
            "name"          =>$post['name'],
            "display_name"  =>$post['display_name'],
            "description"   =>$post['description'],
            "as_modifiers"  => isset($post['modifiers']) ? 1 : 0,
            "premade"       => isset($post['premade']) ? 1 : 0,
            "enable_stock"  => isset($post['enable_stock']) ? 1 : 0,
            "active"        => (int)$post['active'],
            "sell_price"    => floatval(str_replace(".", "", $post['sell_price'])),
            "alert_qty"     => (float)$post['alert_qty'],
        ];
        $save = $foodMenu->update($post['foodmenu_id'],$edit_foodmenu);
        if(!$save) {
            return error_response(json_encode($foodMenu->errors()),400);
        }
        $itemID = $post['foodmenu_id'];
        $categoryID =[];
        foreach ($category as $item) {
            $set = [
                'foodmenu_id' => $itemID,
                'category_id' => $item
            ];
            array_push($categoryID,$set);
        }
        $foodMenu->insertFoodMenuCategoryMap($itemID,$categoryID);
        $data['food'] = $edit_foodmenu;
        $data['redirect'] = "master/food_menu";
        $data['category'] = $category;
        return json_response($data,200,$message);
    }
}