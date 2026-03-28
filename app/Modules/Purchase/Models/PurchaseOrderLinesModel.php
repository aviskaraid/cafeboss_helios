<?php

namespace Modules\Purchase\Models;

use CodeIgniter\Model;

class PurchaseOrderLinesModel extends Model
{
    protected $table      = 'purchase_order_lines'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["transaction_id","item_id","stock_on_hand","closed",
    "pr_line_id","par_stock","purchase_stock","warehouse_id","remark","price","total_price","selected",
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

    public function updateCloseAndSelected($data, $selected = null, $close = null){
        $builder = $this->builder();
        foreach ($data as &$item) {
            if($close != ''){
                $builder->where('id',$item['id']);
                $builder->where("item_id",$item['item_id']);
                $builder->where("transaction_id",$item['transaction_id']);
                $item['updated_at'] = date('Y-m-d H:i:s');
                $item['closed'] = $close;
                $item['updated_by'] = session()->get('user_login')->id;
                $builder->update($item);
            }
            if($selected != ''){
                $builder->where('id',$item['id']);
                $builder->where("item_id",$item['item_id']);
                $builder->where("transaction_id",$item['transaction_id']);
                $item['updated_at'] = date('Y-m-d H:i:s');
                $item['selected'] = $selected;
                $item['updated_by'] = session()->get('user_login')->id;
                $builder->update($item);
            }
        }
        return;
    }
}