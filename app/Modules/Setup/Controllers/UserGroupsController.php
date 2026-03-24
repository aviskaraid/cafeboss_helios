<?php

namespace Modules\Setup\Controllers;

use App\Controllers\BaseController;
use Modules\Setup\Models\MainMenuModel;
use Modules\Setup\Models\UserGroupsModel;

class UserGroupsController extends BaseController
{   
    private $module = 'Setup'; // Module name

    public function index(){
        $usergroups = new UserGroupsModel();
        $keyword = $this->request->getGet('keyword');
		$data = $usergroups->getPaginated(10, $keyword);
        return hmvcView($this->module, 'usergroups_list', $data);
    }
    public function create(){
        $data['title'] = "User Groups"; 
        return hmvcView($this->module, 'usergroups_create', $data);
    }
    public function create_process(){
        $groups = new UserGroupsModel();
         $rules = [
            'name'      	    => 'required|min_length[2]|max_length[25]',
            'description'      	=> 'required|min_length[2]|max_length[100]',
        ];
        if ($this->validate($rules)) {
                $post = $this->request->getPost();
                $addInsert['name'] = trim(strtolower($post['name']));
                $addInsert['description'] = $post['description'];
                $addInsert['active'] = 1;
                $addSave = $groups->insert($addInsert);
                if(!$addSave) {
			       return redirect()->back()->withInput()->with('errors', $groups->errors());
                } else {
                    return redirect()->to(site_url('user_groups/list'))->with('success', 'Data Berhasil Disimpan');
                }
        }else{
             return redirect()->back()->with('error', $this->validator->listErrors());
        }
    }
    public function edit($id){
        $userGroups = new UserGroupsModel();
        $where = ["id"=>$id];
        $getGroups= $userGroups->getFind($where);
        $countResult = $userGroups->countAllResults();
        $getOrder = $userGroups->getOrderNumber($countResult);
        $data['groups'] = $getGroups[0];
        $data['order_number'] = $getOrder;
        return hmvcView($this->module, 'usergroups_edit', $data);
    }
    public function changes($id = null){
        $usergroups         = new UserGroupsModel(); // Instantiate your model
        $rules = [
            'name'      	    => 'required|min_length[2]|max_length[30]',
            'description'      	=> 'required|min_length[2]|max_length[100]',
        ];
         if ($this->validate($rules)) {
            $post = $this->request->getPost();
            $addInsert['name'] = trim($post['name']);
            $addInsert['description'] = $post['description'];
            $addInsert['order_number'] = (int)$post['order_number'];
            $addInsert['active'] = 1;
            $update = $usergroups->update($id,$addInsert);
            if (!$update) {
                return redirect()->back()->withInput()->with('errors', $usergroups->errors());
            } else {
                return redirect()->to(site_url('settings/user_groups'))->with('success', 'Data Berhasil Disimpan');
            }
        }else {
            $data['validation'] = $this->validator;
            return redirect()->back()->with('error', $this->validator->listErrors());
		}
	}

    public function access_edit($id = null){
        $init_access = new MainMenuModel();
        $userGroups = new UserGroupsModel();
        $whereGroup = ["id"=>$id];
        $getGroup = $userGroups->getFind($whereGroup)[0];
        $whereAccessGroup = ["id"=>$id];
        $accessGroup = $userGroups->getAccessGroups($whereAccessGroup);
        $whereLogic = ["active" => 1,"order_number !="=>0];
        $orderBy = ["order_number"=>"asc"];
        $nested = ["access"=>"main_module_id"];
        $getAccess = $init_access->getFind($whereLogic,$orderBy,null,0,0,$nested);
         $getAccessGroups = [];
        foreach ($accessGroup as $j) {
            $buid = $j->access_parent_id.";".$j->access_child_id;
            array_push($getAccessGroups, $buid);
		}
        $data['access_menu']    = $getAccess;
        $data['groups']          = $getGroup;
        $data['access_group']   = $getAccessGroups;
        //dd($data);
        return hmvcView($this->module, 'usergroups_access', $data);
	}

    public function access_changes($id = null){
        $usergroups         = new UserGroupsModel(); // Instantiate your model
        $rules = [
            'group_id'      	    => 'required',
        ];
         if ($this->validate($rules)) {
             $post = $this->request->getPost();
             $groups_accesss = $post['groups_access'];
             $prpare = [];
             foreach ($groups_accesss as $item) {
                $bon = explode(";",$item);
                $parent = $bon[0];
                $child = $bon[1];

				$setUp = [
                    'group_id' => $id,
					'access_parent_id' => $parent,
                    'access_child_id'=>$child
				];
				array_push($prpare,$setUp);
			}
			$usergroups->addRemoveAccess($id,$prpare);
            return redirect()->to(site_url('settings/user_groups'))->with('success', 'Data Berhasil Disimpan');
            //dd($prpare);
        }else {
            $data['validation'] = $this->validator;
            return redirect()->back()->with('error', $this->validator->listErrors());
		}
	}
}