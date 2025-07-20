<?php
namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class CartController extends BaseController
{
    protected $productModel;
    protected $session;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->session = session();
    }

    public function index()
    
    {
        
        $cart = $this->session->get('cart') ?? [];
        $cartItems = [];
        $totalPrice = 0;

        foreach ($cart as $key => $item) {
            if (!isset($item['id'])) {
                $parts = explode('-', $key);
                $item['id'] = $parts[0] ?? null;
                $item['size'] = $parts[1] ?? null;
            }

            if (!isset($item['id'])) continue;

            $product = $this->productModel->find($item['id']);
            if ($product) {
                $qty  = $item['qty'] ?? 1;
                $size = $item['size'] ?? null;

                $cartItems[$key] = [
                    'id'            => $product['id'],
                    'name'          => $product['name'],
                    'price'         => $product['price'],
                    'image'         => $product['image'],
                    'stock'         => $product['stock'],
                    'qty'           => $qty,
                    'size'          => $size,
                    'category_name' => $product['category_name'] ?? '',
                    'subtotal'      => $product['price'] * $qty
                ];

                $totalPrice += $product['price'] * $qty;
            }
        }

        return view('frontend/cart/index', [
            'title'      => 'Keranjang Belanja',
            'cartItems'  => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

public function add($id = null)
{
    $productId = $this->request->getPost('product_id') ?? $id;
    $qty       = (int)$this->request->getPost('qty') ?? 1;
    $size      = $this->request->getPost('size') ?? 'nosize';

    if (!$productId || $qty < 1) {
        return redirect()->back()->with('error', 'Data produk tidak valid.');
    }

    $product = $this->productModel->find($productId);
    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    $cart = $this->session->get('cart') ?? [];
    $key = $productId . '_' . $size;

    if (isset($cart[$key])) {
        $cart[$key]['qty'] += $qty;
    } else {
        $cart[$key] = [
            'id'    => $productId,
            'name'  => $product['name'],
            'price' => $product['price'],
            'qty'   => $qty,
            'size'  => $size,
            'image' => $product['image'] ?? null
        ];
    }

    $this->session->set('cart', $cart);

    return redirect()->to('/cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
}

    public function updateQuantity($key)
    {
        $key = urldecode($key);

        $qty = (int) $this->request->getPost('qty');
        $cart = $this->session->get('cart') ?? [];

        if (!isset($cart[$key])) {
            return redirect()->to('/cart')->with('error', 'Item tidak ditemukan.');
        }

        $productId = explode('-', $key)[0];
        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->to('/cart')->with('error', 'Produk tidak valid.');
        }

        if ($qty < 1) {
            return redirect()->to('/cart')->with('error', 'Jumlah minimal adalah 1.');
        }

        if ($qty > $product['stock']) {
            return redirect()->to('/cart')->with('error', 'Stok tidak mencukupi.');
        }

        $cart[$key]['qty'] = $qty;
        $this->session->set('cart', $cart);
        $this->updateCartTotal($cart);
        
        return redirect()->to('/cart')->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove($key)
    {
        $key = urldecode($key);

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$key])) {
            unset($cart[$key]);
            $this->session->set('cart', $cart);
            $this->updateCartTotal($cart);

            return redirect()->to('/cart')->with('success', 'Produk dihapus dari keranjang.');
        }

        return redirect()->to('/cart')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function clear()
    {
        $this->session->remove('cart');
        $this->session->set('cart_total', 0);

        return redirect()->to('/cart')->with('success', 'Keranjang dikosongkan.');
    }

    private function updateCartTotal(array $cart)
    {
        $totalQty = 0;
        foreach ($cart as $item) {
            $totalQty += $item['qty'];
        }

        $this->session->set('cart_total', $totalQty);
    }
}
