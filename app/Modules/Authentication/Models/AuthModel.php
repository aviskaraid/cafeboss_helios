<?php

namespace Modules\Authentication\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table      = 'users'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function processLoginEmail($data){
        $db = \Config\Database::connect();
        $users = $db->table('users');
        $users->where("email",$data->email);
        $check = $users->get()->getRow();
        if($check==null){
            return responseM(false,"User Not Found");
        }
        if(!password_verify($data->password, $check->password_hash)) {
             return responseM(false,"Invalid Password");
        }
        if($check->active == 0){
            return responseM(false,"User Not Active");
        }
        $data = ["user"=>$check];
        return responseM(true,"Success Login",$data);
    }

    public function getAuthGroups($userId){
        $db = \Config\Database::connect();
        $groupsUser = $db->table('user_groups_users');
        $groupsUser->where("user_id",$userId);
        $groupsUser->join('user_groups a', 'a.id = user_groups_users.group_id');
        $check = $groupsUser->get()->getRow();
        $menu = $db->table('groups_access');
        $menu->select("a.main_module_id as id,b.name, b.icon_image");
        $menu->join('access a', 'a.id = groups_access.access_parent_id');
        $menu->join('main_menu b', 'b.id = a.main_module_id');
        $menu->where("groups_access.group_id",$check->id);
        $menu->orderBy("b.order_number","asc");
        $menu->groupBy("b.id");
        $getMenu = $menu->get()->getResult();
        foreach ($getMenu as $key => $value) {    
            $module_menu = $db->table('groups_access');
            $module_menu->select("a.id,a.label_name as name,a.main_module_id,a.url,a.icon_image");
            $module_menu->join('access a', 'a.id = groups_access.access_parent_id');
            $module_menu->where("a.main_module_id",$value->id);
            $module_menu->groupBy("a.id");
            $getmodule_menu= $module_menu->get()->getResult();
            $value->module=$getmodule_menu;
        }
        $access = $db->table('groups_access');
        $access->select("groups_access.*,b.label_name as module_name,b.url as module_url,a.label_name as function_name,a.url as function_url, b.main_module_id");
        $access->join('access a', 'a.parent_id = groups_access.access_parent_id and a.id = groups_access.access_child_id');
        $access->join('access b', 'b.id = a.parent_id');
        $access->where("group_id",$check->id);
        $getAccess = $access->get()->getResult();
        $access_user = [];
        foreach ($getAccess as $key => $value) {
            $jj = [$value->access_parent_id=>$value->access_child_id];
            array_push($access_user,$jj);
        }   
        $check->access=$access_user;
        $check->menu=$getMenu;
        $data = ["groups"=>$check];
        //dd($data);
        return responseM(true,"Success Get Groups",$data);
    }
}