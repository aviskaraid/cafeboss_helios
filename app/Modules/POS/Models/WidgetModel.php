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
            $table1->join("pos_table_area b","b.store_id = a.store_id");
            $table1->join("pos_table c","c.area_id = b.id");
            $table1->where('a.type', "sell");
            $table1->where('a.status', $status);
            $table1->where('b.store_id', $location_id);
            $table1->select("a.*,b.id as area_ia,b.name as area_name,c.id as table_id,c.name as table_name");
            $table1->orderBy("a.created_at","DESC");
            $getPos = $table1->get()->getResult();
        return $getPos;
    }

}