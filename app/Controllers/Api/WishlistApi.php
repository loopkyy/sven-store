<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class WishlistApi extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $wishlist = session()->get('wishlist') ?? [];
        log_message('error', 'WISHLIST: ' . json_encode(session()->get('wishlist')));
        $products = [];

        if (!empty($wishlist)) {
            $wishlist = array_map('intval', $wishlist);
            $productModel = new ProductModel();

            $products = $productModel
                ->whereIn('id', $wishlist)
                ->findAll();
        }

        return $this->respond([
            'status' => true,
            'wishlist' => $products
        ]);
    }

    public function add()
    {
        $productId = (int) $this->request->getVar('product_id'); 
        log_message('error', 'SESSION ISI: ' . json_encode(session()->get()));


        if ($productId <= 0) {
            return $this->failValidationErrors('ID produk tidak valid.');
        }

        // Cek apakah produk benar-benar ada
        $productModel = new ProductModel();
        $product = $productModel->find($productId);
        if (!$product) {
            return $this->failNotFound('Produk tidak ditemukan.');
        }

        $wishlist = session()->get('wishlist') ?? [];

        if (!in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            $wishlist = array_unique($wishlist); // jaga-jaga
            session()->set('wishlist', $wishlist);
        }

        return $this->respond([
            'status' => true,
            'message' => 'Produk ditambahkan ke wishlist.',
            'wishlist' => $wishlist
        ]);
    }

    public function remove()
    {
        $productId = (int) $this->request->getVar('product_id');

        if ($productId <= 0) {
            return $this->failValidationErrors('ID produk tidak valid.');
        }

        $wishlist = session()->get('wishlist') ?? [];

        $wishlist = array_filter($wishlist, fn ($item) => (int) $item !== $productId);
        session()->set('wishlist', array_values($wishlist));

        return $this->respond([
            'status' => true,
            'message' => 'Produk dihapus dari wishlist.',
            'wishlist' => $wishlist
        ]);
    }

    public function clear()
    {
        session()->remove('wishlist');

        return $this->respond([
            'status' => true,
            'message' => 'Wishlist dikosongkan.'
        ]);
    }

    public function count()
    {
        $wishlist = session()->get('wishlist') ?? [];
        return $this->respond([
            'status' => true,
            'count' => count($wishlist)
        ]);
    }
}
