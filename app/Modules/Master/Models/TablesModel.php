<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class TablesModel extends Model
{
    protected $table      = 'pos_table'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["area_id","name","description","type","person",
                                "spesificaion","reservation","reservation_name","open_at",
                                "close_at"];

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
            $builder->like('code', $keyword);
            $builder->orLike('name', $keyword);
            $builder->orLike('description', $keyword);
        }
        return [
            'tables' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }

    public function getPaginated_area($num, $keyword = null, $status = 1) {
        $db = \Config\Database::connect();
        $builder = $db->table('pos_table_area'); // Specify the other table
        if($keyword != '') {
            $builder->like('name', $keyword);
            $builder->orLike('description', $keyword);
        }
        $area = $this->paginate($num);
        // foreach($area as $key=>&$value){
        //     $childBuilder = $db->table('stores');
        //     $childBuilder->where("id",$value->store_id);
        //     $qr = $childBuilder->get()->getRow();
        //     $area[$key]['store'] = $qr;
        // }
        return [
            'area_tables' => $area,
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

    public function insertTableArea($data){
        $db = \Config\Database::connect();
        $builder = $db->table('pos_table_area');
        $db->transCommit();
        $builder->insert($data);
        $db->transComplete();
    }
}