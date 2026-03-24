<?php

namespace Modules\POS\Models;

use CodeIgniter\Model;

class PosTransactionsModel extends Model
{
    protected $table      = 'pos_transactions'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["pos_id","type","sub_type","remark","payment_method","customer_id",
                                "table_id","sequence","transaction_date","ref_no","disc_type","disc_amount",
                                "tax_id","tax_amount","tax_id","tax_amount","created_by",
                                "updated_by","deleted_by"];

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
}