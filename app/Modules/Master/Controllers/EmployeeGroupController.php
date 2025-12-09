<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\EmployeeGroupsModel;

class EmployeeGroupController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $employeegroup = new EmployeeGroupsModel();
        $keyword = $this->request->getGet('keyword');
		$data = $employeegroup->getPaginated(10, $keyword);
        $data['title'] = "Employee Group List";
        return hmvcView($this->module, 'employeegroup_list', $data);
    }

    public function create(){
        $data['title'] = "Create Employee Group";
        $data['generate_code'] = becko_employeegrouop_code(8,true);
        return hmvcView($this->module, 'employeegroup_create', $data);
    }

    public function generate_employeegroup_code(){
        $code = becko_employeegrouop_code(8,true);
        $message = "successfully Generate Employee Group Code";
        $data['user_code'] = $code;
        return $this->respond($code);
    }

    public function create_process(){
        $warehouse = new EmployeeGroupsModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $save = $warehouse->save($post);
        if($save) {
            $message = "successfully Inserted";
            $data['redirect'] = "master/employee_group";
            return json_response($data,200,$message);
        } else {
            $data['errors'] = $warehouse->errors();
            return json_response($data, 400);
        }
    }

    

}