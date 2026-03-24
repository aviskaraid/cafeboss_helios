<?php

namespace Modules\Purchase\Models;

use CodeIgniter\Model;

class PurchaseRequestLinesModel extends Model
{
    protected $table      = 'purchase_request_lines'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["transaction_id","item_id","stock_on_hand","sr_line_id","par_stock","request_stock","warehouse_id","remark",
                                "created_by","updated_by","deleted_by","created_at","updated_at","deleted_at","deleted"];

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

    public function UpdateLines($transaction_id){
        $builder = $this->builder();
        $builder->where("transaction_id",$transaction_id);
        $builder->where("deleted",1);
        $builder->where("deleted_at", null);
        $getData = $builder->get()->getRow();
        return $getData;
    }
}