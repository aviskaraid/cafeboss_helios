<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class FoodMenuCategoryModel extends Model
{
    protected $table      = 'foodmenu_category'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["category_name","sub_category_name","label_name","parent_id","icon_image",
                                "url","active","created_by","updated_by","deleted_by"];

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
            $builder->like('category_name', $keyword);
            $builder->orLike('sub_category_name', $keyword);
            $builder->orLike('label_name', $keyword);
        }
        return [
            'foodmenu_category' => $this->paginate($num),
            'pager' => $this->pager,
        ];
    }
    
    public function getCategory($order = ""){
        $builder = $this->builder();
        $builder->where("category_name !=",""); 
        if($order!=""){
            $builder->orderBy($order, "desc");
        }
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
}