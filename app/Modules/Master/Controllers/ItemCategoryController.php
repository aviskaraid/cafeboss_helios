<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\ItemCategoryModel;

class ItemCategoryController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $units = new ItemCategoryModel();
        $keyword = $this->request->getGet('keyword');
		$data = $units->getPaginated(10, $keyword);
        $data['title'] = "Item Category List";
        return hmvcView($this->module, 'itemcategory_list', $data);
    }
    public function create(){
		$category = new ItemCategoryModel();
        $getCat = $category->getCategory();
        $data['title'] = "Item Category";
        $data['category'] = $getCat;
        return hmvcView($this->module, 'itemcategory_create', $data);
    }

    public function create_process(){
            $access = new ItemCategoryModel(); 
            $post = $this->request->getJSON(true);
            $parent_id      = $post['parent_id'];
            if($parent_id=="0"){
                $trimString = trim($post['label_name']);
                $addInsert['name'] = strtolower(str_replace(" ","",$trimString));
            }
            if($parent_id!="0"){
                $trimString = trim($post['label_name']);
                $addInsert['sub_name'] = strtolower(str_replace(" ","",$trimString));
            };
            $addInsert['label_name'] = trim($post['label_name']);
            $addInsert['parent_id'] = (int)$parent_id;
            $addInsert['active'] = 1;
            $save = $access->insert($addInsert);
            if($save) {
                $message = "successfully Inserted";
                $data['redirect'] = "master/itemcategory";
                return json_response($data,200,$message);
            } else {
                $data['errors'] = $access->errors();
                return json_response($data, 400);
            }
    }
}