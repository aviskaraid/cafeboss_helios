<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table      = 'supplier'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['ref_code','name','description','address','contact','phone_number','location','account',
                                'account_number','remark','type','group_id','picture','status','status_message',
                                'active',"created_by","updated_by","deleted_by"];

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

    public function getPaginated($num, $keyword = null) {
        $builder = $this->builder();
        $builder->select('
        id,ref_code,location,name,description,address,phone_number,active,contact,group_id');
        if($keyword != '') {
            $builder->like('name', $keyword);
            $builder->orLike('description', $keyword);
            $builder->orLike('address', $keyword);
            $builder->orLike('location', $keyword);
        }
        $result = $this->paginate($num);
        // foreach($result as $key=>&$value){
        //     $db = \Config\Database::connect();
        //     $builder = $db->table('purchase'); // Specify the other table
        //     $builder->where("contact_id",$value['id']);
        //     $qr = $builder->get()->getResult();
        //     $result[$key]['purchase'] = $qr;
        // }
        return [
            'suppliers' => $result,
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
}