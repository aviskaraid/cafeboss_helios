<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\StoresModel;
use Modules\Master\Models\TablesModel;
use Modules\Master\Models\TableAreaModel;

class TablesController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $warehouse = new TablesModel();
        $keyword = $this->request->getGet('keyword');
		$data = $warehouse->getPaginated(10, $keyword);
        $data['title'] = "Tables List";
        return hmvcView($this->module, 'table_list', $data);
    }
    public function area_list(){
        $area = new TableAreaModel();
        $keyword = $this->request->getGet('keyword');
		$data = $area->getPaginated(10, $keyword);
        $data['title'] = "Area Tables List";
        //dd($data);
        return hmvcView($this->module, 'table_area_list', $data);
    }

    public function create(): string{
        $data['title'] = "New Table"; 
        return hmvcView($this->module, 'table_create', $data);
    }

    public function area_create(): string{
        $data['title'] = "New Table Area"; 
        return hmvcView($this->module, 'table_area_create', $data);
    }

    public function area_create_process(){
        $areas = new TablesModel();
        $post = $this->request->getJSON(true);
        $message = "Successfully";
        $add_tableArea =[
            "business_id"       =>1,
            "name"              =>$post['name'],
            "description"       =>$post['description'],
            "store_id"          =>$post['input_store'],
            "location"          =>$post['location'],
            "spesification"     =>$post['spesification'],
            "ac"                => isset($post['ac']) ? 1 : 0,
            "smoking"           => isset($post['smoking']) ? 1 : 0,
            "meeting"           => isset($post['meeting']) ? 1 : 0
        ];
        $areas->insertTableArea($add_tableArea);
        $data['post'] = $post;
        $data['redirect'] = "master/table/area";
        return json_response($data,200,$message);
    }

    public function create_process(){
        $tables = new TablesModel();
        $post = $this->request->getJSON(true);
        $message = "Successfully";
        $add_table =[
            "name"              =>$post['name'],
            "description"       =>$post['description'],
            "area_id"           =>$post['input_area'],
            "person"            =>$post['person'],
            "spesification"     =>$post['spesification']
        ];
        $tables->insert($add_table);
        $data['post'] = $post;
        $data['redirect'] = "master/table";
        return json_response($data,200,$message);
    }
}