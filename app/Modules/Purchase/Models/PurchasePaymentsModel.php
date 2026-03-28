<?php

namespace Modules\Purchase\Models;

use CodeIgniter\Model;

class PurchasePaymentsModel extends Model
{
    protected $table      = 'purchase_payments'; // Table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["transaction_id","po_code","transaction_date","type",
                                "amount","changes","remark","status",
                                "account_number","account_name","account_bank","ref_number",
                                "created_by","updated_by","deleted_by","created_at","updated_at","deleted_at"];


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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}