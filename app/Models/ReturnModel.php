<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturnModel extends Model
{
    protected $table = 'returns';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'reason', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function withOrder()
    {
        return $this->select('returns.*, users.username')
                    ->join('orders', 'orders.id = returns.order_id')
                    ->join('users', 'users.id = orders.user_id');
    }
}
