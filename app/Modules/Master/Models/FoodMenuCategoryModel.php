<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class FoodMenuCategoryModel extends Model
{
    protected $table      = 'foodmenu_category'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["category_name","sub_category_name","label_name","parent_id","icon_image",
                                "url","active","created_by","updated_by","deleted_by"];

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

    public function getPaginated($num, $keyword = null, $status = 1) {
        $builder = $this->builder();
        $builder->join("foodmenu_category parent", "parent.id = foodmenu_category.parent_id", "left");
        $builder->select("foodmenu_category.*,
        parent.label_name AS parent_name");
        $builder->orderBy("COALESCE(parent.id, zax_foodmenu_category.id),zax_foodmenu_category.id");
        if($keyword != '') {
            $builder->like('name', $keyword);
        }
        $result = $this->paginate($num);
        return [
            'foodmenucategory' => $result,
            'pager' => $this->pager,
        ];
    }
    
    public function getCategory($order = "",$sub = false){
        $builder = $this->builder();
        $builder->where("category_name !=",""); 
        if($sub){
            $builder->where("parent_id =",0);
        }
        if($order!=""){
            $builder->orderBy($order, "desc");
        }
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    public function getFind($whereConditions = null, $orderConditions = null, $groupbyCondition = null, $limit = 0, $offset = 0, array $nested = [], array $join = [], array $column = []){
        $builder = $this->builder();
        if(!empty($column)){
            $col = implode(', ', $column);
            $builder->select("{$col}");
        }
        if(!empty($join)){
            foreach ($join as $Nestedkey) {
                    $from = $Nestedkey['from'];    
                    $fieldCol = $Nestedkey['field'];
                    $sourceCol = $Nestedkey['source'];
                $builder->join("{$from}","{$fieldCol} = {$sourceCol}");
            }
        }
         if ($whereConditions != null){
            $builder->groupStart();
            foreach ($whereConditions as $key => $value) {
                $builder->where($key,$value);
            }
            $builder->groupEnd();
        }
        if($groupbyCondition != null){
            foreach ($groupbyCondition as $by => $escape) {
                $builder->groupBy($by, $escape);
            }
        }
        if($orderConditions != null){
            foreach ($orderConditions as $order => $direction) {
                $builder->orderBy($order, $direction);
            }
        }
        if($limit != 0 ){
            $builder->limit($limit,0);
        }
        if($limit != 0 && $offset != 0){
            $builder->limit($limit,$offset);
        }
        $result = $builder->get()->getResult();
        if(!empty($nested)){
            $db = \Config\Database::connect();
            foreach ($result as &$key) {
                foreach ($nested as $Nestedkey => $Nestedvalue) {
                        $child = $db->table($Nestedkey); // Specify the other table
                        $child->where($Nestedvalue,$key->parent_id);
                        $qr = $child->get()->getRow();
                        $key->$Nestedkey = $qr;
                 }
            }
        }
        
        return $result;
    }
}