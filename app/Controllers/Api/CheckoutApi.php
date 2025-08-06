<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use App\Models\CouponModel;
use App\Models\PaymentMethodModel;

class CheckoutApi extends BaseController
{
     use ResponseTrait;
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;
    protected $couponModel;
    protected $paymentMethodModel;

    public function __construct()
    {
        $this->orderModel         = new OrderModel();
        $this->orderItemModel     = new OrderItemModel();
        $this->productModel       = new ProductModel();
        $this->couponModel        = new CouponModel();
        $this->paymentMethodModel = new PaymentMethodModel();
    }

    public function process()
    {
        $json = $this->request->getJSON(true);

        if (!$json) {
            return $this->fail('Invalid JSON');
        }

        $userId   = $json['user_id'] ?? null;
        $name     = $json['name'] ?? null;
        $email    = $json['email'] ?? null;
        $phone    = $json['phone'] ?? null;
        $address  = $json['address'] ?? null;
        $note     = $json['note'] ?? null;
        $methodId = $json['payment_method_id'] ?? null;
        $couponCode = $json['coupon'] ?? null;
        $cart     = $json['cart'] ?? [];

        if (!$userId || !$name || !$email || !$phone || !$address || !$methodId || empty($cart)) {
            return $this->fail('Semua data wajib diisi.');
        }

        $total = 0;
        $discount = 0;

        foreach ($cart as $item) {
            $product = $this->productModel->find($item['id']);
            if (!$product) continue;

            $subtotal = $product['price'] * $item['qty'];
            $total += $subtotal;
        }

        if ($couponCode) {
            $coupon = $this->couponModel
                ->where('code', $couponCode)
                ->where('is_active', 1)
                ->first();

            if ($coupon) {
                $discount = $coupon['type'] === 'percent'
                    ? ($coupon['value'] / 100) * $total
                    : $coupon['value'];

                $discount = min($discount, $total);
                $total -= $discount;
            }
        }

        $orderData = [
            'user_id'           => $userId,
            'name'              => $name,
            'email'             => $email,
            'phone'             => $phone,
            'address'           => $address,
            'note'              => $note,
            'total'             => $total,
            'discount'          => $discount,
            'coupon_code'       => $couponCode,
            'status'            => 'pending',
            'shipping_status'   => 'not_shipped',
            'payment_method_id' => $methodId,
        ];

        $orderId = $this->orderModel->insert($orderData);

        foreach ($cart as $item) {
            $product = $this->productModel->find($item['id']);
            if (!$product) continue;

            $this->orderItemModel->insert([
                'order_id'   => $orderId,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'price'      => $product['price'],
                'size'       => $item['size'] ?? null,
            ]);
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Pesanan berhasil dibuat',
            'order_id' => $orderId,
        ]);
    }
}
