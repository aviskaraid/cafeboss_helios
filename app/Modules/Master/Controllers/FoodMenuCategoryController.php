<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\FoodMenuCategoryModel;

class FoodMenuCategoryController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $units = new FoodMenuCategoryModel();
        $keyword = $this->request->getGet('keyword');
		$data = $units->getPaginated(10, $keyword);
        $data['title'] = "Food Menu Category";
        //dd($data);
        return hmvcView($this->module, 'foodmenu_category_list', $data);
    }

    public function create(){
		$category = new FoodMenuCategoryModel();
        $getCat = $category->getCategory(null,true);
        $data['title'] = "Item Category";
        $data['category'] = $getCat;
        return hmvcView($this->module, 'foodmenu_category_create', $data);
    }

    public function edit($id = null){
        $getData = new FoodMenuCategoryModel();
        $where = ['id'=>$id];
        $get = $getData->getFind($where,null,null,0,0)[0];
        $listCategory = $getData->getCategory(null,true);
        $data['category'] = $listCategory;
        $data['title'] = "Edit ( ".$get->label_name." )";
        $data['data'] = $get;
        //dd($data);
        return hmvcView($this->module, 'foodmenu_category_edit', $data);
    }
    
    public function create_process(){
            $access = new FoodMenuCategoryModel(); 
            $post = $this->request->getJSON(true);
            $parent_id      = $post['parent_id'];
            $trimString = trim($post['label_name']);
            $addInsert['category_name'] = strtolower(str_replace(" ","",$trimString));
            $addInsert['label_name'] = trim($post['label_name']);
            $addInsert['parent_id'] = (int)$parent_id;
            $addInsert['active'] = 1;
            $save = $access->insert($addInsert);
            if($save) {
                $message = "successfully Inserted";
                $data['redirect'] = "master/foodmenucategory";
                return json_response($data,200,$message);
            } else {
                $data['errors'] = $access->errors();
                return json_response($data, 400);
            }
    }

    public function changes($id = null){
            $category = new FoodMenuCategoryModel(); 
            $post = $this->request->getJSON(true);
            $parent_id      = $post['parent_id'];
            $trimString = trim($post['label_name']);
            $addInsert['category_name'] = strtolower(str_replace(" ","",$trimString));
            $addInsert['label_name'] = trim($post['label_name']);
            $addInsert['parent_id'] = (int)$parent_id;
            $addInsert['active'] = 1;
            $save = $category->update($id,$addInsert);
            if($save) {
                $message = "successfully Updated";
                $data['redirect'] = "master/foodmenucategory";
                return json_response($data,200,$message);
            } else {
                $data['errors'] = $category->errors();
                return json_response($data, 400);
            }
    }
}