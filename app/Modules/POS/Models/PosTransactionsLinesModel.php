<?php

namespace Modules\POS\Models;

use CodeIgniter\Model;

class PosTransactionsLinesModel extends Model
{
    protected $table      = 'pos_transactions_lines'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["transaction_id","foodmenu_id","quantity","price","disc","tax",
                                "sub_total","total","combo","modifiers","remark",
                                "created_by","updated_by","deleted_by"];

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

    public function getFoodMenuByLines($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('foodmenu');
        $builder->select('foodmenu.*,
        a.category_id as category_id,c.quantity as quantity');
        $builder->join('foodmenu_category_map a', 'a.foodmenu_id = foodmenu.id');
        $builder->join('store_category_map b', 'b.category_id = a.category_id');
        $builder->join('pos_transactions_lines c', 'c.foodmenu_id = foodmenu.id');
        if($keyword != '') {
            $builder->where('c.transaction_id', $keyword);
        }
        $builder->groupBy("foodmenu.id");
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getMemberByLines($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('customers');
        $builder->select('customers.*,
        a.id as transaction_id');
        $builder->join('pos_transactions_lines a', 'a.foodmenu_id = foodmenu.id');
        if($keyword != '') {
            $builder->where('c.transaction_id', $keyword);
        }
        $builder->groupBy("foodmenu.id");
        $result = $builder->get()->getResultArray();
        return $result;
    }
}