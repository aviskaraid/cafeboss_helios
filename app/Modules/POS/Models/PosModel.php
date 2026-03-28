<?php

namespace Modules\POS\Models;

use CodeIgniter\Model;

class PosModel extends Model
{
    protected $table      = 'pos'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["business_id","store_id","user_id","status","shift","open_at",
                                "opening_amount","close_at","closing_amount","total_cash","total_card","total_transfer",
                                "closing_note","created_by","updated_by","deleted_by","session_pos"];

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
    protected $beforeInsert   = ['callBackCreate'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['callBackUpdate'];
    protected $afterUpdate    = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['callBackDelete'];

    protected function callBackCreate (array $data){
        if (isset($data['data'])) {
                $data['data']['created_by'] = session()->get('user_login')->id;
            }
        return $data;
    }
    protected function callBackUpdate (array $data){
        if (isset($data['data'])) {
                $data['data']['updated_by'] = session()->get('user_login')->id;
            }
        return $data;
    }
    protected function callBackDelete (array $data){
         $this->db->table($this->table)
                 ->where($this->primaryKey, $data['id']) // Or $data['primaryKey']
                 ->set('deleted_by', session()->get('user_login')->id)
                 ->update();

        return $data;
    }
    
    public function getFind($date=null,$whereConditions = null, $orderConditions = null, $groupbyCondition = null, $limit = 0, $offset = 0) {
        $builder = $this->builder();
        if ($whereConditions != null){
            $builder->where($whereConditions);
        }
        if ($date != null){
            $builder->like($date);
        }
        if($orderConditions != null){
            foreach ($orderConditions as $column => $direction) {
                $builder->orderBy($column, $direction);
            }
        }
        if($groupbyCondition != null){
            foreach ($groupbyCondition as $column => $direction) {
                $builder->groupBy($column, $direction);
            }
        }
        if($limit != 0 ){
            $builder->limit($limit,0);
        }
        if($limit != 0 && $offset != 0){
            $builder->limit($limit,$offset);
        }
        
        $result = $builder->get()->getResult();
        return $result;
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
}