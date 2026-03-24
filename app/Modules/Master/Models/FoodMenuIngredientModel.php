<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class FoodMenuIngredientModel extends Model
{
    protected $table      = 'foodmenu_ingredient'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["item_id","warehouse_id","consumption","cost","total",
                                "foodmenu_id","active","created_by","created_at","updated_at",
                                "updated_by","deleted_at","deleted_by"];

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
        if($keyword != '') {
            $builder->like('item_id', $keyword);
            $builder->orLike('warehouse_id', $keyword);
            $builder->orLike('foodmenu_id', $keyword);
        }
        return [
            'foodmenu' => $this->paginate($num),
            'pager' => $this->pager,
        ];
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
                        $child->where($Nestedvalue,$key->id);
                        $qr = $child->get()->getResult();
                        $key->$Nestedkey = $qr;
                 }
            }
        }
        return $result;
    }
    public function saveBom($data){
        $builder = $this->builder();
        foreach ($data as &$item) {
            $builder->where("item_id",$item['item_id']);
            $builder->where("foodmenu_id",$item['foodmenu_id']);
             $builder->where("warehouse_id",$item['warehouse_id']);
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
            $item['active'] = 1;
            $item['created_by'] = session()->get('user_login')->id;
            $record = $builder->get()->getRow();
            if ($record) {
    
            }else{
                $builder->insert($item);
            }
        }
        return;
    }
}