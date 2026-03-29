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

    protected $allowedFields = ["pos_id","type","start","end","shift","sub_type","status","store_id","remark","method","customer_id",
                                "table_id","sequence","transaction_date","customer_id","ref_no","disc_type","sub_total","total","disc_amount",
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

    public function getMemberByLines($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('customers');
        $builder->select('customers.*,
        a.id as transaction_id');
        $builder->join('pos_transactions a', 'a.customer_id = customers.id');
        if($keyword != '') {
            $builder->where('a.id', $keyword);
        }
        $builder->groupBy("customers.id");
        $result = $builder->get()->getRow();
        return $result;
    }

    // public function getSummaryTransaction($keyword = null) {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('pos_transactions');
    //     $builder->select('count(pos_transactions.id) as total_transaction');
    //     $builder->join('customers', 'customers.id = pos_transactions.customer_id');
    //     $builder->join('pos_table', 'pos_table.id = pos_transactions.table_id');
    //     $builder->join('users', 'users.id = pos_transactions.created_by');
    //     $builder->join('pos_transactions_payments', 'pos_transactions_payments.transaction_id = pos_transactions.id');
    //     $builder->join('pos', 'pos.id = pos_transactions.pos_id');
    //     if($keyword != '') {
    //         $builder->where('pos.id',$keyword);
    //     }
    //     $result = $builder->get()->getResult();

    //     return $result;
    // }

    public function getSummaryTransaction($keyword = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('pos_transactions a');
    //     $builder->select("SUM(CASE WHEN pos_transactions_payments.method = 'Cash' or 'cash' THEN Amount ELSE 0 END) AS TotalCash,
    // SUM(CASE WHEN pos_transactions_payments.method IN ('Card', 'Credit') THEN Amount ELSE 0 END) AS TotalCardCredit");
        $builder->select("
        COUNT(a.id) AS Total_Transaction,
        SUM(b.amount-b.changes) AS Amount_Transaction,
        SUM(CASE WHEN a.status = 'final' THEN 1 ELSE 0 END) AS Total_Final,
        SUM(CASE WHEN a.status = 'final' THEN a.sub_total ELSE 0 END) AS Amount_Final,
        SUM(CASE WHEN a.status = 'hold' or 'pending' THEN 1 ELSE 0 END) AS Total_Pending,
        SUM(CASE WHEN a.status = 'hold' or 'pending' THEN a.sub_total ELSE 0 END) AS Amount_Pending,
        SUM(CASE WHEN b.method = 'Cash' or 'cash' THEN 1 ELSE 0 END) AS Total_Cash,
        SUM(CASE WHEN b.method = 'Cash' or 'cash' THEN (Amount-Changes) ELSE 0 END) AS Amount_Cash,
        SUM(CASE WHEN b.method = 'Card' or 'card' THEN 1 ELSE 0 END) AS Total_Card,
        SUM(CASE WHEN b.method = 'Card' or 'card' THEN (Amount-Changes) ELSE 0 END) AS Amount_Card,
        SUM(CASE WHEN b.method = 'Bank_Transfer' or 'Bank_Transfer' THEN 1 ELSE 0 END) AS Total_Bank_Transfer,
        SUM(CASE WHEN b.method = 'Bank_Transfer' or 'Bank_Transfer' THEN (Amount-Changes) ELSE 0 END) AS Amount_Bank_Transfer
        ");
        $builder->join('pos_transactions_payments b', 'b.transaction_id = a.id');
        $builder->join('pos c', 'c.id = a.pos_id');
        if($keyword != '') {
            $builder->where('c.id',$keyword);
        }
        $result = $builder->get()->getRow();

        return $result;
    }
}