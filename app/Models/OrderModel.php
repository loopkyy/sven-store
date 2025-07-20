<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
    'user_id', 'total', 'status', 'shipping_status', 'payment_method_id', 'created_at', 'updated_at'
];
public function countPendingOrders()
{
    return $this->where('status', 'pending')->countAllResults();
}


}
