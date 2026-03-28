<?php

namespace Modules\POS\Models;

use CodeIgniter\Model;

class WidgetModel extends Model
{
    protected $table      = ''; // Table name
    protected $primaryKey = 'id';


    public function getTransactionPendingBranch($location_id,$status) {
        $db = \Config\Database::connect();
            $table1 = $db->table('pos_transactions a'); // Specify the other table
            $table1->join("pos_table c","c.id = a.table_id");
            $table1->join("pos_table_area b","b.id = c.area_id");
            $table1->where('a.type', "resto");
            $table1->where('a.status', $status);
            $table1->where('b.store_id', $location_id);
            $table1->select("c.*,
                b.id as area_id,
                b.store_id as store_id,
                b.smoking as area_smoking,
                b.meeting as area_meeting,
                b.ac as area_ac");
            $table1->groupBy("a.id");
            $table1->orderBy("a.created_at","DESC");
            $result = $table1->get()->getResultArray();
            foreach($result as $key=>&$value){
                $db = \Config\Database::connect();
                $childBuilder = $db->table('pos_transactions'); // Specify the other table
                $childBuilder->where("table_id",$value['id']);
                $getPosTrans = $childBuilder->get()->getRow();
                $value['pos_transaction'] = $getPosTrans;
            }
        return $result;
    }

}