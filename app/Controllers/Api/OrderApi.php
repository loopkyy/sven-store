<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use CodeIgniter\API\ResponseTrait;

class OrderApi extends BaseController
{
    use ResponseTrait;

    public function history()
    {
        // Ambil user dari session (atau nanti token kalau sudah login API)
        $userId = session()->get('user_id');

        if (!$userId) {
            return $this->failUnauthorized('Unauthorized');
        }

        $orderModel = new OrderModel();
        $orders = $orderModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->respond([
            'status' => true,
            'message' => 'Order history retrieved',
            'data' => $orders
        ]);
    }
}
