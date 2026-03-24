<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\ItemCategoryModel;

class ItemCategoryController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $catModel = new ItemCategoryModel();
        $keyword = $this->request->getGet('keyword');
		$data = $catModel->getPaginated(10, $keyword);
        $data['title'] = "Item Category List";
        //dd($data);
        return hmvcView($this->module, 'itemcategory_list', $data);
    }
    public function create(){
		$category = new ItemCategoryModel();
        $listCategory = $category->getCategory(null,true);
        $data['title'] = "Item Category";
        $data['category'] = $listCategory;
        //dd($listCategory);
        return hmvcView($this->module, 'itemcategory_create', $data);
    }

    public function create_process(){
            $category = new ItemCategoryModel(); 
            $post = $this->request->getJSON(true);
            $parent_id      = $post['parent_id'];
            $trimString = trim($post['label_name']);
            $addInsert['name'] = strtolower(str_replace(" ","",$trimString));
            $addInsert['label_name'] = trim($post['label_name']);
            $addInsert['parent_id'] = (int)$parent_id;
            $addInsert['active'] = 1;
            $save = $category->insert($addInsert);
            if($save) {
                $message = "successfully Inserted";
                $data['redirect'] = "master/itemcategory";
                return json_response($data,200,$message);
            } else {
                $data['errors'] = $category->errors();
                return json_response($data, 400);
            }
    }
    public function edit($id = null){
        $getData = new ItemCategoryModel();
        $where = ['id'=>$id];
        $get = $getData->getFind($where,null,null,0,0)[0];
        $listCategory = $getData->getCategory(null,true);
        $data['category'] = $listCategory;
        $data['title'] = "Edit ( ".$get->label_name." )";
        $data['data'] = $get;
        //dd($data);
        return hmvcView($this->module, 'itemcategory_edit', $data);
    }

    public function changes($id = null){
            $category = new ItemCategoryModel(); 
            $post = $this->request->getJSON(true);
            $parent_id      = $post['parent_id'];
            $trimString = trim($post['label_name']);
            $addInsert['name'] = strtolower(str_replace(" ","",$trimString));
            $addInsert['label_name'] = trim($post['label_name']);
            $addInsert['parent_id'] = (int)$parent_id;
            $addInsert['active'] = 1;
            $save = $category->update($id,$addInsert);
            if($save) {
                $message = "successfully Updated";
                $data['redirect'] = "master/itemcategory";
                return json_response($data,200,$message);
            } else {
                $data['errors'] = $category->errors();
                return json_response($data, 400);
            }
    }
}