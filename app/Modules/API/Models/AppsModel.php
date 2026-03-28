<?php

namespace Modules\API\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

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
        $childBuilder->where("status","hold");
        $getPosTrans = $childBuilder->get()->getRow();
        $value['pos_transaction'] = $getPosTrans;
        }
        return $result;
    }
    public function getItemCategory($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('item_category child');
        $builder->join("item_category parent", "parent.id = child.parent_id", "left");
        $builder->select("child.id as id,child.name as name,child.label_name as label_name,child.parent_id as parent_id,
        parent.label_name AS parent_name");
        $builder->orderBy("COALESCE(parent.id, child.id),child.id");
        if($keyword != '') {
            $builder->like('child.name', $keyword);
            $builder->orLike('child.id', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }
    // public function getItemCategory($keyword = null) {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('item_category a');
    //     $builder->select("if(b.parent_id > 0,b.id,a.id) as id, if(b.parent_id > 0,b.name,a.name) as name,if(b.parent_id>0,CONCAT(a.label_name, ' | ', b.label_name),a.label_name) as label_name,if(b.parent_id > 0,b.parent_id,a.parent_id) as parent_id");
    //     $builder->join("item_category b","b.parent_id = a.id","left");
    //     $builder->where("a.active = 1");
    //     $builder->groupBy("id");
    //     if($keyword != '') {
    //        $builder->like('a.label_name', $keyword);
    //     }       
    //     $query = $builder->get();
    //     return $query->getResult();
    // }

    public function getItemsUnits($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('units');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->where('id', $keyword);
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

    public function getItemsLocation($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('item_location a');
        $builder->join("warehouse b","b.id = a.warehouse_id");
        if($keyword != '') {
            $builder->like('a.item_id', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

        public function getItemsbyLocation($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('items a');
        $builder->join("item_location b","b.item_id = a.id");
        $builder->join("warehouse c","c.id = b.warehouse_id");
        $builder->join("item_stock d","d.item_id = a.id and d.warehouse_id = c.id","left");
         $builder->select("a.id as item_id,a.name as item_name,
        a.code as item_code,a.sku as item_sku,a.description as item_description,
        a.category_id as item_category_id,
        c.name as warehouse_name,c.id as warehouse_id,
        d.stock_qty as stock");
         $builder->where("a.active", 1);
        if($keyword != '') {
            $builder->Like('c.id', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getItemsDetailbyLocation($keyword = null) {
        $db = \Config\Database::connect();
        $keyItem = explode("_", $keyword);
        $itemId = $keyItem[0];
        $warehouse = $keyItem[1];
        $builder = $db->table('items a');
        $builder->join("item_location b","b.item_id = a.id");
        $builder->join("warehouse c","c.id = b.warehouse_id");
        $builder->join("item_stock d","d.item_id = a.id and d.warehouse_id = c.id","left");
        $builder->join("item_price e","e.item_id = a.id and e.warehouse_id = c.id","left");
        $builder->join("units f","f.id = a.main_unit","left");
        $builder->select("a.id as item_id,a.name as item_name,
        a.code as item_code,a.sku as item_sku,a.description as item_description,
        a.category_id as item_category_id,
        c.name as warehouse_name,c.id as warehouse_id,
        d.stock_qty as stock,e.hpp as item_hpp, e.sell_price as item_sell_price,
        e.sell_price_tax as item_sell_price_tax,f.description as main_unit");
         $builder->where("a.active", 1);
        $builder->where('a.ingredient', 1);
        $builder->where('a.id', $itemId);
        $builder->where('c.id', $warehouse);   
        $query = $builder->get();
        return $query->getRow();
    }

    public function getItemsPrice($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('item_price ');
        if($keyword != '') {
            $builder->like('item_id', $keyword);
        }
        $builder->groupBy("item_id,warehouse_id",false);       
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
           $builder->orLike('id', $keyword);
        }       
        $query = $builder->get();
        return $query->getResult();
    }

    public function getSupplier($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table(tableName: 'supplier');
        $builder->where("active = 1");
        if($keyword != '') {
           $builder->like('name', $keyword);
           $builder->orLike('id', $keyword);
           $builder->orLike( 'ref_code', $keyword);
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

    public function getSupplierbyItem($id = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('items a');
        $builder->join("item_supplier_map z","z.item_id = a.id","left");
        $builder->join("supplier b","b.id = z.supplier_id","left");
        if($id!=''){
            $builder->where("a.id",$id);
        }
        $builder->groupBy("b.id");
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

    public function getFoodMenu($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('foodmenu');
        $builder->select('foodmenu.*,
        a.category_id as category_id');
        $builder->join('foodmenu_category_map a', 'a.foodmenu_id = foodmenu.id');
        $builder->join('store_category_map b', 'b.category_id = a.category_id');
        if($keyword != '') {
            $builder->where('b.store_id', $keyword);
        }
        $builder->groupBy("foodmenu.id");
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getCustomer($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('customers');
        if($keyword != '') {
            $builder->where('username', $keyword);
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }


    public function getBomFoodMenu($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('foodmenu_ingredient a');
        $builder->join("items z","z.id = a.item_id");
        $builder->join("item_location b","b.item_id = a.item_id and b.warehouse_id = a.warehouse_id");
        $builder->join("warehouse c","c.id = b.warehouse_id");
        $builder->join("item_stock d","d.item_id = z.id and d.warehouse_id = c.id","left");
        $builder->join("item_price e","e.item_id = z.id and e.warehouse_id = c.id","left");
        $builder->join("units f","f.id = z.main_unit","left");
        $builder->select("z.id as item_id,z.name as item_name,a.consumption as consumption,a.total as total_cost,
        z.code as item_code,z.sku as item_sku,z.description as item_description,
        z.category_id as item_category_id,
        c.name as warehouse_name,c.id as warehouse_id,
        d.stock_qty as stock,e.hpp as item_hpp, e.sell_price as item_sell_price,
        e.sell_price_tax as item_sell_price_tax,f.description as main_unit");
        if($keyword != '') {
            $builder->where('a.foodmenu_id', $keyword);
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function check_parstock($keyword = null,$supplier = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('items a');
        $builder->join("item_location b","b.item_id = a.id");
        $builder->join("warehouse c","c.id = b.warehouse_id");
        $builder->join("item_stock d","d.item_id = a.id and d.warehouse_id = c.id","left");
        $builder->join("units f","f.id = a.purchase_unit","left");
        $builder->join("item_supplier_map g","g.item_id = a.id","left");
        $builder->join("supplier h","h.id = g.supplier_id","left");
        $builder->select("
        c.name as warehouse_name,c.id as warehouse_id,
        a.alert_qty as par_stock,
        a.id as item_id,d.id as item_id_stock,a.name as item_name,
        a.code as item_code,a.sku as item_sku,a.description as item_description,
        a.category_id as item_category_id,
        d.stock_qty as stock_on_hand,f.description as main_unit,
        g.supplier_id as supplier_id, h.name as suppplier_name");
        if($keyword != '') {
            $builder->where('a.id', $keyword);
            $builder->orWhere('c.id', $keyword);
        }
        $builder->groupBy("a.id, c.id");
        if($supplier != '') {
            $builder->where('g.supplier_id', $keyword);
            $builder->groupBy("a.id, c.id, g.supplier_id");
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getStockRequestHeader($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('stock_request a');
        $builder->where('a.status', "Approved");
        $builder->where('a.closed', 0);
        if($keyword != '') {
            $builder->where('a.id', $keyword);
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }
    public function getStockRequest($keyword = null, $supplier = null, $selected = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('stock_request_lines a');
        $builder->join("items z","z.id = a.item_id");
        $builder->join("item_location b","b.item_id = a.item_id and b.warehouse_id = a.warehouse_id");
        $builder->join("warehouse c","c.id = b.warehouse_id");
        $builder->join("item_stock d","d.item_id = z.id and d.warehouse_id = c.id","left");
        $builder->join("item_price e","e.item_id = z.id and e.warehouse_id = c.id","left");
        $builder->join("units f","f.id = z.purchase_unit","left");
        $builder->join("item_supplier_map g","g.item_id = a.item_id","left");
        $builder->join("supplier h","h.id = g.supplier_id","left");
        $builder->select("a.id as index_id, a.par_stock as par_stock, a.stock_on_hand , a. request_stock, 
        c.name as warehouse_name,c.id as warehouse_id,
        z.id as item_id,d.id as item_id_stock,z.name as item_name,
        z.code as item_code,z.sku as item_sku,z.description as item_description,
        z.category_id as item_category_id,
        d.stock_qty as stock_on_hand,f.description as main_unit, e.purchase_price,e.purchase_price_tax,e.hpp,
        g.supplier_id as supplier_id, h.name as suppplier_name,a.selected as selected");
        if($selected != '') {
            $builder->where('a.selected', 0);
        }
        if($keyword != '') {
            $builder->where('a.transaction_id', $keyword);
            $builder->groupBy("a.item_id, a.warehouse_id");
        }
        if($keyword != '' && $supplier != '') {
            $builder->where('a.transaction_id', $keyword);
            $builder->where('g.supplier_id', $supplier);
            $builder->groupBy("a.item_id, a.warehouse_id, g.supplier_id");
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getTaktikalBySupplier($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('taktikal a');
        $builder->select("a.*,b.name as supplier_name");
        $builder->join("supplier b","b.id = a.supplier_id");
        $builder->where('a.active', 1);
        $builder->where('a.supplier_id', $keyword);       
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getTaktikalById($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('taktikal a');
        $builder->select("a.*,b.name as supplier_name");
        $builder->join("supplier b","b.id = a.supplier_id");
        $builder->where('a.active', 1);
        $builder->where('a.id', $keyword);       
        $result = $builder->get()->getResultArray();
        return $result;
    }
    public function getPurchaseRequestHeader($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('purchase_request a');
        $builder->where('a.status', "Approved");
        $builder->where('a.closed', 0);
        if($keyword != '') {
            $builder->where('a.id', $keyword);
            
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }
    public function getPurchaseRequest($keyword = null, $supplier = null, $selected = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('purchase_request_lines a');
        $builder->join("items z","z.id = a.item_id");
        $builder->join("item_location b","b.item_id = a.item_id and b.warehouse_id = a.warehouse_id");
        $builder->join("warehouse c","c.id = b.warehouse_id");
        $builder->join("item_stock d","d.item_id = z.id and d.warehouse_id = c.id","left");
        $builder->join("item_price e","e.item_id = z.id and e.warehouse_id = c.id","left");
        $builder->join("units f","f.id = z.purchase_unit","left");
        $builder->join("item_supplier_map g","g.item_id = a.item_id","left");
        $builder->join("supplier h","h.id = g.supplier_id","left");
        $builder->select("a.id as index_id, a.deleted, a.sr_line_id,a.transaction_id, a.par_stock as par_stock, a.stock_on_hand , a. request_stock,
        c.name as warehouse_name,c.id as warehouse_id,
        z.alert_qty as par_stock,
        z.id as item_id,d.id as item_id_stock,z.name as item_name,
        z.code as item_code,z.sku as item_sku,z.description as item_description,
        z.category_id as item_category_id,
        d.stock_qty as stock_on_hand,f.description as main_unit, e.purchase_price,e.purchase_price_tax,e.hpp,
        g.supplier_id as supplier_id, h.name as suppplier_name,a.selected as selected");
        if($selected != '') {
            $builder->where('a.selected', 0);
        }
        if($keyword != '') {
            $builder->where('a.transaction_id', $keyword);
            $builder->groupBy("a.item_id, a.warehouse_id");
        }
        if($keyword != '' && $supplier != '') {
            $builder->where('a.transaction_id', $keyword);
            $builder->where('g.supplier_id', $supplier);
            $builder->groupBy("a.item_id, a.warehouse_id, g.supplier_id");
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getPurchaseOrderHeader($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('purchase_order a');
        $builder->where('a.status', "Approved");
        $builder->where('a.closed', 0);
        if($keyword != '') {
            $builder->where('a.id', $keyword);
            
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }
    public function getPurchaseOrder($keyword = null, $warehouse = null, $selected = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('purchase_order_lines a');
        $builder->join("items z","z.id = a.item_id");
        $builder->join("item_location b","b.item_id = a.item_id and b.warehouse_id = a.warehouse_id");
        $builder->join("warehouse c","c.id = b.warehouse_id");
        $builder->join("item_stock d","d.item_id = z.id and d.warehouse_id = c.id","left");
        $builder->join("item_price e","e.item_id = z.id and e.warehouse_id = c.id","left");
        $builder->join("units f","f.id = z.purchase_unit","left");
        $builder->join("item_supplier_map g","g.item_id = a.item_id","left");
        $builder->join("supplier h","h.id = g.supplier_id","left");
        $builder->select("a.id as index_id, a.deleted, a.pr_line_id,a.transaction_id, a.par_stock as par_stock, a.stock_on_hand ,a.price,a.total_price,a.purchase_stock,
        c.name as warehouse_name,c.id as warehouse_id,
        z.alert_qty as par_stock,
        z.id as item_id,d.id as item_id_stock,z.name as item_name,
        z.code as item_code,z.sku as item_sku,z.description as item_description,
        z.category_id as item_category_id,
        d.stock_qty as stock_on_hand,f.description as main_unit, e.purchase_price,e.purchase_price_tax,e.hpp,
        g.supplier_id as supplier_id, h.name as suppplier_name,a.selected as selected");
        if($selected != '') {
            $builder->where('a.selected', 0);
        }
        if($keyword != '') {
            $builder->where('a.transaction_id', $keyword);
            $builder->groupBy("a.item_id, a.warehouse_id");
        }
        if($keyword != '' && $warehouse != '') {
            $builder->where('a.transaction_id', $keyword);
            $builder->where('a.warehouse_id', $warehouse);
            $builder->groupBy("a.item_id, a.warehouse_id, g.supplier_id");
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }



    // update //

    public function post_remove_item_PR($keyword){
        $part = explode("_",$keyword);
        $id = $part[0];
        $trans_id = $part[1];
        $PRLines = $this->db->table("purchase_request_lines")
                ->where('transaction_id',$trans_id) // Or $data['primaryKey']
                ->where('id', $id)
                ->set('deleted', 1)
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->update();
        return $PRLines;
    }

    public function post_remove_item_PO($keyword){
        $part = explode("_",$keyword);
        $id = $part[0];
        $trans_id = $part[1];
        $PRLines = $this->db->table("purchase_order_lines")
                ->where('transaction_id',$trans_id) // Or $data['primaryKey']
                ->where('id', $id)
                ->set('deleted', 1)
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->update();
        return $PRLines;
    }

    public function post_updatePending_SR($itemId){
         return $this->db->table("stock_request")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Pending')
                ->update();
    }

    public function post_updateApprove_SR($itemId){
         return $this->db->table("stock_request")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Approved')
                ->set('approval_id', session()->get('user_login')->id)
                ->update();
    }

    public function post_updateDecline_SR($itemId){
         return $this->db->table("stock_request")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Rejected')
                ->set('approval_id', session()->get('user_login')->id)
                ->update();
    }

    public function post_updatePending_PR($itemId){
         return $this->db->table("purchase_request")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Pending')
                ->update();
    }

    public function post_updateApprove_PR($itemId){
         return $this->db->table("purchase_request")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Approved')
                ->set('approval_id', session()->get('user_login')->id)
                ->update();
    }
    public function post_updateDecline_PR($itemId){
         return $this->db->table("purchase_request")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Rejected')
                ->set('approval_id', session()->get('user_login')->id)
                ->update();
    }

    public function post_updatePending_PO($itemId){
         return $this->db->table("purchase_order")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Pending')
                ->update();
    }

    public function post_updateApprove_PO($itemId){
         return $this->db->table("purchase_order")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Approved')
                ->set('approval_id', session()->get('user_login')->id)
                ->update();
    }
    public function post_updateDecline_PO($itemId){
         return $this->db->table("purchase_order")
                ->where($this->primaryKey, $itemId) // Or $data['primaryKey']
                ->set('approval_date', date('Y-m-d H:i:s'))
                ->set('updated_at', date('Y-m-d H:i:s'))
                ->set('status','Canceled')
                ->set('approval_id', session()->get('user_login')->id)
                ->update();
    }


}