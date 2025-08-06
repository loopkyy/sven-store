<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table      = 'coupons';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code', 'type', 'value', 'max_uses', 'used_count',
        'min_order', 'max_discount', 'start_date', 'end_date',
        'is_active', 'created_at', 'updated_at'
    ];
}
