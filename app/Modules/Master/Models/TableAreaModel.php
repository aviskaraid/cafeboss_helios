<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class TableAreaModel extends Model
{
    protected $table      = 'pos_table_area'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["business_id","location_id","name","description","ac","smoking","meeting",
                                "location","smoking","spesification","open_at","close_at","created_by",
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

  protected $allowCallbacks = true;
    protected $beforeInsert   = ['callBackCreate'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['callBackUpdate'];
    protected $afterUpdate    = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['callBackDelete'];

    protected function callBackCreate (array $data){
        if (isset($data['data'])) {
                $data['data']['created_by'] = session()->get('id');
            }
        return $data;
    }
    protected function callBackUpdate (array $data){
        if (isset($data['data'])) {
                $data['data']['updated_by'] = session()->get('id');
            }
        return $data;
    }
    protected function callBackDelete (array $data){
         $this->db->table($this->table)
                 ->where($this->primaryKey, $data['id']) // Or $data['primaryKey']
                 ->set('deleted_by', session()->get('id'))
                 ->update();

        return $data;
    }

    public function getPaginated($num, $keyword = null, $status = 1) {
        $builder = $this->builder();
        $builder->select('pos_table_area.*,
        a.name as store_name,
        a.description as store_description');
        $builder->join('stores a', 'a.id = pos_table_area.store_id');
        if($keyword != '') {
            $builder->like('pos_table_area.name', $keyword);
            $builder->orLike('pos_table_area.description', $keyword);
        }
        return [
            'area_tables' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }

    public function getFind($whereConditions = null, $orderConditions = null, $groupbyCondition = null, $limit = 0, $offset = 0) {
        $builder = $this->builder();
        $builder->select('pos_table_area.*,
        a.id as branch_id,
        a.business_id as business_id,
        a.name as branch_name,
        a.description as branch_description');
        $builder->join('branch a', 'a.id = pos_table_area.location_id');
        if ($whereConditions != null){
            $builder->where($whereConditions);
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

    public function getPosArea($location = null,$keyword = null,$status = 1) {
        $builder = $this->builder();
        $builder->select('pos_table_area.*,
        a.id as branch_id,
        a.name as branch_name,
        a.description as branch_description');
        $builder->join('branch a', 'a.id = pos_table_area.location_id');
        $builder->where("pos_table_area.active",$status);
        if($keyword != '') {
            $builder->like('name', $keyword);
            $builder->orLike('description', $keyword);
        }
        if($location != '') {
            $builder->where('location_id', $location);
        }    
        $query = $builder->get();
        return $query->getResultArray();
    }
}