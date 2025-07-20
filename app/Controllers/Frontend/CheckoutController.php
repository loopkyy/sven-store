<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentMethodModel;
use App\Models\CouponModel;
use App\Models\ProductModel;

class CheckoutController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentMethodModel;
    protected $couponModel;
    protected $productModel;
    protected $session;

    public function __construct()
    {
        $this->orderModel         = new OrderModel();
        $this->orderItemModel     = new OrderItemModel();
        $this->paymentMethodModel = new PaymentMethodModel();
        $this->couponModel        = new CouponModel();
        $this->productModel       = new ProductModel();
        $this->session            = session();
    }

    public function index()
    {
        $cart   = $this->session->get('cart') ?? [];
        $coupon = $this->session->get('coupon');
        $total  = 0;
        $items  = [];

        foreach ($cart as $item) {
            $productId = $item['id'] ?? null;
            $qty       = intval($item['qty'] ?? 1);

            if (!$productId) continue;

            $product = $this->productModel->find($productId);
            if ($product) {
                $price    = floatval($product['price']);
                $subtotal = $price * $qty;
                $total   += $subtotal;

                $items[] = [
                    'product'  => $product,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                    'size'     => $item['size'] ?? null,
                ];
            }
        }

        $discount = 0;
        if ($coupon) {
            $couponData = $this->couponModel
                ->where('code', $coupon)
                ->where('is_active', 1)
                ->first();

            if ($couponData) {
                if ($couponData['type'] === 'percent') {
                    $discount = ($couponData['value'] / 100) * $total;
                } elseif ($couponData['type'] === 'fixed') {
                    $discount = $couponData['value'];
                }

                $discount = min($discount, $total);
                $total -= $discount;
            }
        }

        $paymentMethods = $this->paymentMethodModel
            ->where('is_active', 1)
            ->findAll();

        $availableCoupons = $this->couponModel
            ->where('is_active', 1)
            ->findAll();

        return view('frontend/checkout/index', [
            'items'           => $items,
            'total'           => $total,
            'discount'        => $discount,
            'coupon'          => $coupon ?? null,
            'paymentMethods'  => $paymentMethods,
            'availableCoupons'=> $availableCoupons,
        ]);
    }

    public function process()
    {
        $cart     = $this->session->get('cart') ?? [];
        $userId   = $this->session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        $name      = $this->request->getPost('name');
        $email     = $this->request->getPost('email');
        $phone     = $this->request->getPost('phone');
        $address   = $this->request->getPost('address');
        $note      = $this->request->getPost('note');
        $methodId  = $this->request->getPost('payment_method_id');
        $couponCode = $this->request->getPost('coupon');

        if (!$name || !$email || !$phone || !$address || !$methodId) {
            return redirect()->back()->with('error', 'Lengkapi semua data yang diperlukan.');
        }

        $total    = 0;
        $discount = 0;

        foreach ($cart as $item) {
            $productId = $item['id'] ?? null;
            $qty       = intval($item['qty'] ?? 1);

            if (!$productId) continue;

            $product = $this->productModel->find($productId);
            if ($product) {
                $price  = floatval($product['price']);
                $total += $price * $qty;
            }
        }

        if ($couponCode) {
            $couponData = $this->couponModel
                ->where('code', $couponCode)
                ->where('is_active', 1)
                ->first();

            if ($couponData) {
                if ($couponData['type'] === 'percent') {
                    $discount = ($couponData['value'] / 100) * $total;
                } elseif ($couponData['type'] === 'fixed') {
                    $discount = $couponData['value'];
                }

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
            $productId = $item['id'] ?? null;
            $qty       = intval($item['qty'] ?? 1);

            if (!$productId) continue;

            $product = $this->productModel->find($productId);
            if ($product) {
                $price = floatval($product['price']);

                $this->orderItemModel->insert([
                    'order_id'   => $orderId,
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'price'      => $price,
                    'size'       => $item['size'] ?? null,
                ]);
            }
        }

        $this->session->remove('cart');
        $this->session->remove('coupon');

        return redirect()->to('/')->with('success', 'Pesanan berhasil dibuat.');
    }
public function direct()
{
    $productId = $this->request->getPost('product_id');
    $quantity  = $this->request->getPost('qty') ?? 1;
    $size      = $this->request->getPost('size');

    // Ambil detail produk
    $product = $this->productModel->find($productId);
    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    // Format sesuai yang dibaca oleh method index()
    $this->session->set('cart', [
        [
            'id'   => $productId,
            'qty'  => (int)$quantity,
            'size' => $size
        ]
    ]);

    return redirect()->to(base_url('checkout'));
}

}
