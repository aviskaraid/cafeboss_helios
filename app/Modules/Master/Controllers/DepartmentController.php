<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\DepartmentsModel;

class DepartmentController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $departments = new DepartmentsModel();
        $keyword = $this->request->getGet('keyword');
		$data = $departments->getPaginated(10, $keyword);
        $data['title'] = "Department List";
        return hmvcView($this->module, 'department_list', $data);
    }
    public function create(){
        $data['title'] = "New Department"; 
        $data['generate_code'] = becko_department_code(8,true); 
        return hmvcView($this->module, 'department_create', $data);
    }
    public function generate_department_code(){
        $code = becko_department_code(8,true);
        $message = "successfully Generate Department Code";
        $data['user_code'] = $code;
        return $this->respond($code);
    }

    public function create_process(){
        $user = new DepartmentsModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $post['business_id'] = 1;
        $save = $user->save($post);
        if($save) {
            $message = "successfully Inserted";
            $data['redirect'] = "settings/users";
            return json_response($data,200,$message);
        } else {
            $data['errors'] = $user->errors();
            return json_response($data, 400);
        }
    }
}