<?php

namespace Modules\Setup\Models;

use CodeIgniter\Model;

class UserGroupsModel extends Model
{
    protected $table      = 'user_groups'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["name","description","active","created_by","updated_by","deleted_by"];

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
            $builder->like('name', $keyword);
        }
        return [
            'user_groups' => $this->paginate($num),
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
                    $child = $db->table($Nestedkey); 
                    $child->where($Nestedvalue,$key->id);
                    $module = $child->get()->getResult();
                    $key->$Nestedkey = $module;
                }
            }
        }
        return $result;
    }

    public function getOrderNumber($count){    
        $data = [];
        for ($i=1; $i < $count; $i++) {
            $builder = $this->builder();
            $builder->where("order_number",$i);
            $gets = $builder->get()->getRow();
            if($gets == null){
                $data[$i] = ["id"=>$i,"number"=>"No ".$i];
            }
             
        }
        return $data;
    }

    public function getAccessGroups($id){    
        $db = \Config\Database::connect();
        $main = $db->table("groups_access"); 
        $main->where("group_id",$id);
        $get = $main->get()->getResult();
        return $get;
    }

     public function addRemoveAccess($groups,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('groups_access'); // Specify the other table
        $builder->where("group_id",$groups);
        $record = $builder->get()->getRow();
        if ($record) {
            $builder->where('group_id', $groups)
            ->delete();
        }
        $db->transCommit();
        foreach ($data as $item) {
            $builder->insert($item);
        }
        $db->transComplete();
    }
}