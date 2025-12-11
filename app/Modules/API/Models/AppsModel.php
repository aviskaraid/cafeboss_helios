<?php

namespace Modules\API\Models;

use CodeIgniter\Model;

class AppsModel extends Model
{
    protected $table      = 'apps'; // Table name
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

   public function getAccessUserMenu($userId){
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


    public function getGroups($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('user_groups');
        $builder->where("active",1);
        if($keyword != '') {
            $builder->like('name', strtolower($keyword));
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getPosTableArea($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('pos_table_area');
        $builder->where("business_id",1);
        if($keyword != '') {
            $builder->like('store_id', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getPosTable($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('pos_table');
        $builder->select('pos_table.*,
        a.id as area_id,
        a.store_id as store_id,
        a.smoking as area_smoking,
        a.meeting as area_meeting,
        a.ac as area_ac');
        $builder->join('pos_table_area a', 'a.id = pos_table.area_id');
        if($keyword != '') {
            $builder->where('a.store_id', $keyword);
        }
        $result = $builder->get()->getResultArray();
        foreach($result as $key=>&$value){
        $db = \Config\Database::connect();
        $childBuilder = $db->table('pos_transactions'); // Specify the other table
        $childBuilder->where("table_id",$value['id']);
        $getPosTrans = $childBuilder->get()->getRow();
        $value['sales'] = $getPosTrans;
        }
        return $result;
    }

    public function getItemCategory($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('item_category a');
        $builder->select("if(b.parent_id > 0,b.id,a.id) as id, if(b.parent_id > 0,b.name,a.name) as name,if(b.parent_id>0,CONCAT(a.label_name, ' | ', b.label_name),a.label_name) as label_name,if(b.parent_id > 0,b.parent_id,a.parent_id) as parent_id");
        $builder->join("item_category b","b.parent_id = a.id","left");
        $builder->where("a.active = 1");
        $builder->groupBy("id");
        if($keyword != '') {
           $builder->like('a.label_name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getItemsUnits($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('units');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->like('id', $keyword);
            $builder->orLike('name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getItemsIngredients($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('items a');
        $builder->select("a.id as id, a.name as name, a.description as description, a.main_unit as main_unit_id,
                        b.description as main_unit,c.sell_price as sell_price");
        $builder->join("units b","b.id = a.main_unit");
        $builder->join("item_price c","c.item_id = a.id and c.warehouse_id=1"); 
        $builder->where("a.active = 1");
        if($keyword != '') {
           $builder->like('id', $keyword);
            $builder->orLike('name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getWarehouse($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('warehouse');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->like('name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getStore($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('stores');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->like('name', $keyword);
           $builder->orLike('id', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDepartment($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('departments');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->like('name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getEmployeeGroup($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('employee_groups');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->like('name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getEmployee($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('employees');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->like('name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getItemUnitsbyItemId($id = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('item_units a');
        $builder->select("a.id as id,a.item_id as item_id,
        a.unit_source as unit_source,a.unit_dest as unit_dest,
        b.description as unit_source_desc,c.description as unit_dest_desc,
        a.value_source as value_source,a.value_dest as value_dest");
        $builder->join("units b","b.id = a.unit_source");
        $builder->join("units c","c.id = a.unit_dest");
        if($id!=''){
            $builder->where("a.item_id",$id);
        }
        $query = $builder->get();
        return $query->getResult();
    }

    public function getItemIngredientbyItemId($id = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('rnd');
        $builder->select("rnd.*,CONCAT(b.first_name,b.last_name) as employee_name");
        $builder->join("employees b","b.id = rnd.employee_id");
         if($id!=''){
            $builder->where("rnd.id",$id);
        }
        $result = $builder->get()->getRow();
        $child = $db->table('rnd_ingredient a');
        $child->select("a.id as id,
        a.item_id as item_id, a.consumption as consumption,
        a.cost as cost, a.total as total, b.description as description,
        c.description as main_unit");
        $child->join("items b","b.id = a.item_id");
        $child->join("units c","c.id = b.main_unit");
        $child->where("a.rnd_id",$result->id);
        $result->ingredients = $child->get()->getResult();
        return $result;
    }

    public function getFoodMenuCategory($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('foodmenu_category a');
        $builder->select("if(b.parent_id > 0,b.id,a.id) as id, if(b.parent_id > 0,b.category_name,a.category_name) as name,if(b.parent_id>0,CONCAT(a.label_name, ' | ', b.label_name),a.label_name) as label_name,if(b.parent_id > 0,b.parent_id,a.parent_id) as parent_id");
        $builder->join("foodmenu_category b","b.parent_id = a.id","left");
        $builder->where("a.active = 1");
        $builder->groupBy("id");
        if($keyword != '') {
           $builder->like('a.label_name', $keyword);
           $builder->orLike('b.label_name', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getFoodMenuCategorybyStore($id = null) {
        $db = \Config\Database::connect();
       $builder = $db->table('foodmenu_category a');
        $builder->select("if(b.parent_id > 0,b.id,a.id) as id, if(b.parent_id > 0,b.category_name,a.category_name) as name,if(b.parent_id>0,CONCAT(a.label_name, ' | ', b.label_name),a.label_name) as label_name,if(b.parent_id > 0,b.parent_id,a.parent_id) as parent_id");
        $builder->join("foodmenu_category b","b.parent_id = a.id","left");
        $builder->join("store_category_map z","z.category_id = a.id or z.category_id = b.id","left");
        if($id!=''){
            $builder->where("z.store_id",$id);
        }
        $builder->groupBy("id");
        $query = $builder->get();
        return $query->getResult();
    }

    public function getFoodMenuCategoryByFoodMenu($id = null) {
        $db = \Config\Database::connect();
       $builder = $db->table('foodmenu_category a');
        $builder->select("if(b.parent_id > 0,b.id,a.id) as id, if(b.parent_id > 0,b.category_name,a.category_name) as name,if(b.parent_id>0,CONCAT(a.label_name, ' | ', b.label_name),a.label_name) as label_name,if(b.parent_id > 0,b.parent_id,a.parent_id) as parent_id");
        $builder->join("foodmenu_category b","b.parent_id = a.id","left");
        $builder->join("foodmenu_category_map z","z.category_id = a.id or z.category_id = b.id","left");
        if($id!=''){
            $builder->where("z.foodmenu_id",$id);
        }
        $builder->groupBy("id");
        $query = $builder->get();
        return $query->getResult();
    }

}