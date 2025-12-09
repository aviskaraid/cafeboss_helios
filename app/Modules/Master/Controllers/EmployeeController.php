<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\EmployeeModel;

class EmployeeController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
        $employee = new EmployeeModel();
        $keyword = $this->request->getGet('keyword');
		$data = $employee->getPaginated(10, $keyword);
        $data['title'] = "Employee List";
        return hmvcView($this->module, 'employee_list', $data);
    }

    public function create(){
        $data['title'] = "Create Employee";
        $data['generate_code'] = becko_employee_code(8,true);
        return hmvcView($this->module, 'employee_create', $data);
    }

    public function generate_employee_code(){
        $code = becko_employee_code(8,true);
        $message = "successfully Generate Employee Code";
        $data['user_code'] = $code;
        return $this->respond($code);
    }

    public function create_process(){
        $emp = new EmployeeModel();
        $post = $this->request->getJSON(true);
        $post['active'] = 1;
        $message="Successfully";
        $add = [
            "code"          =>  $post['code'],
            "first_name"    =>  $post['first_name'],
            "last_name"     =>  $post['last_name'],
            "department_id" =>  $post['department_id'],
            "group_id"      =>  $post['group_id'],
            'active'        => 1
        ];
        $save = $emp->save($post);
        if($save) {
            $message = "successfully Inserted";
            $data['redirect'] = "master/employees";
            return json_response($data,200,$message);
        } else {
            $data['errors'] = $emp->errors();
            return json_response($data, 400);
        }
    }
}