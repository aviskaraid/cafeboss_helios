<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class ItemsModel extends Model
{
    protected $table      = 'items'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["sku","sub_sku","code","name","display_name","description",
                                "category_id","brand_id","type_id","ingredient","premade","purchase_unit",
                                "main_unit","tax","enable_stock","not_for_selling","expired_date","expire_period",
                                "alert_qty","weigth","dimension","picture","active","created_by","updated_by",
                                "deleted_by"];

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

    public function getPaginated($num, $keyword = null, $location = null, $premade = null, $ingredient = null,$chooseType = null, $brand = null, $cat = null) {
        $builder = $this->builder();
        $builder->select('items.*');
        $builder->join('item_location a', 'a.item_id = items.id');
        $builder->join('warehouse b', 'b.id = a.warehouse_id');
        $builder->join('item_price c', 'c.item_id = items.id');
        $builder->join('item_category d', 'd.id = items.category_id');
        if($keyword != ''){
            $builder->groupStart();
            $builder->like('items.sku', $keyword);
            $builder->orLike('items.name', $keyword);
            $builder->orLike('items.description', $keyword);
            $builder->groupEnd();
        }
       
        $builder->groupBy( ['items.id']);
        return [
            'items' => $this->paginate($num),
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

    public function insertLocation($id,$data){
        $db = \Config\Database::connect();
        foreach ($data as $item) {
            $builder = $db->table('item_location'); // Specify the other table
            $builder->where("item_id",$item['item_id']);
            $builder->where("warehouse_id",$item['warehouse_id']);
            $record = $builder->get()->getRow();
            if ($record) {
                $builder->where('item_id', $id)
                ->delete();
            }
            $db->transCommit();
            foreach ($data as $item) {
                $builder->insert($item);
            }
            $db->transComplete();
        }
        $db->transComplete();
    }

    public function insertPrice($id,$data){
        $db = \Config\Database::connect();
        foreach ($data as $item) {
            $builder = $db->table('item_price'); // Specify the other table
            $builder->where("item_id",$item['item_id']);
            $builder->where("warehouse_id",$item['warehouse_id']);
            $record = $builder->get()->getRow();
            if ($record) {
                $builder->where('item_id', $id)
                ->delete();
            }
            $db->transCommit();
            foreach ($data as $item) {
                $builder->insert($item);
            }
            $db->transComplete();
        }
        $db->transComplete();
    }

    public function insertStock($id,$data){
        $db = \Config\Database::connect();
        foreach ($data as $item) {
            $builder = $db->table('item_stock'); // Specify the other table
            $builder->where("item_id",$item['item_id']);
            $builder->where("warehouse_id",$item['warehouse_id']);
            $record = $builder->get()->getRow();
            if ($record) {
                $builder->where('item_id', $id)
                ->delete();
            }
            $db->transCommit();
            foreach ($data as $item) {
                $builder->insert($item);
            }
            $db->transComplete();
        }
        $db->transComplete();
    }

    public function insertItemsUnit($id,$data){
        $db = \Config\Database::connect();
        foreach ($data as $item) {
            $builder = $db->table('item_units'); // Specify the other table
            $builder->where("item_id",$item['item_id']);
            $builder->where("unit_source",$item['unit_source']);
            $builder->where("unit_dest",$item['unit_dest']);
            $record = $builder->get()->getRow();
            if ($record) {
                $builder->where('item_id', $id)
                ->delete();
            }
            $db->transCommit();
            foreach ($data as $item) {
                $builder->insert($item);
            }
            $db->transComplete();
        }
        $db->transComplete();
        if ($this->db->transStatus() === false) {
            // Transaction failed, handle the error (e.g., log, display message)
            return false;
        } else {
            return true;
        }
    }
  
}