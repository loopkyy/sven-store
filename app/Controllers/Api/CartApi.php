<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class CartApi extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $cart = session()->get('cart') ?? [];

        // Tambahkan URL lengkap untuk gambar jika belum
        foreach ($cart as &$item) {
            if (isset($item['image']) && !str_starts_with($item['image'], 'http')) {
                $item['image'] = base_url('uploads/' . $item['image']);
            }
        }

        return $this->respond([
            'status' => true,
            'cart' => $cart,
        ]);
    }

    public function add()
    {
        // Terima data dari form-data / x-www-form-urlencoded
        $productId = $this->request->getPost('product_id');
        $qty = $this->request->getPost('qty');
        $size = $this->request->getPost('size');

        // Jika data tidak ditemukan, coba ambil dari JSON
        if (!$productId) {
            $json = $this->request->getJSON(true);
            $productId = $json['product_id'] ?? null;
            $qty = $json['qty'] ?? $qty;
            $size = $json['size'] ?? $size;
        }

        $qty = ($qty !== null && $qty !== '') ? (int) $qty : 1;
        $size = $size ?? 'nosize';

        if (!$productId || $qty < 1) {
            return $this->fail('Data produk tidak valid.');
        }

        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return $this->failNotFound('Produk tidak ditemukan.');
        }

        // Gunakan image default jika tidak ada
        $image = $product['image'] ?? 'default.png';

        $cart = session()->get('cart') ?? [];
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
                'image' => $image, // Simpan nama file saja
            ];
        }

        session()->set('cart', $cart);

        return $this->respond([
            'status' => true,
            'message' => 'Produk ditambahkan ke keranjang.',
            'cart' => $cart
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);

        $key = $this->request->getPost('key') ?? ($data['key'] ?? null);
        $qty = $this->request->getPost('qty') ?? ($data['qty'] ?? null);

        if (!$key || (int)$qty < 1) {
            return $this->fail('Data tidak valid.');
        }

        $cart = session()->get('cart') ?? [];

        if (!isset($cart[$key])) {
            return $this->failNotFound('Item tidak ditemukan di keranjang.');
        }

        $cart[$key]['qty'] = (int)$qty;
        session()->set('cart', $cart);

        return $this->respond([
            'status' => true,
            'message' => 'Jumlah item berhasil diubah.',
            'cart' => $cart
        ]);
    }


    public function clear()
    {
        session()->remove('cart');
        return $this->respond([
            'status' => true,
            'message' => 'Keranjang dikosongkan.'
        ]);
    }

    public function count()
    {
        $cart = session()->get('cart') ?? [];
        $totalQty = 0;

        foreach ($cart as $item) {
            $totalQty += $item['qty'];
        }

        return $this->respond([
            'status' => true,
            'count' => $totalQty
        ]);
    }
public function removePost()
{
    $data = $this->request->getJSON(true); // ⬅️ penting untuk ambil JSON body
    $key = $data['key'] ?? null;

    if (!$key) {
        return $this->fail('Key tidak ditemukan', 400);
    }

    $cart = session()->get('cart') ?? [];

    if (isset($cart[$key])) {
        unset($cart[$key]);
        session()->set('cart', $cart);

        return $this->respond([
            'status' => true,
            'message' => 'Item berhasil dihapus',
        ]);
    }

    return $this->failNotFound('Item tidak ditemukan di keranjang');
}

}
