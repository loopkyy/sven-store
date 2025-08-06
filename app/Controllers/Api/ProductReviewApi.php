<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ProductReviewApi extends ResourceController
{
    protected $modelName = 'App\Models\ProductReviewModel';
    protected $format    = 'json';

    // ✅ Get semua review per produk
    public function index($productId = null)
    {
        if (!$productId) {
            return $this->fail('Product ID wajib diisi.');
        }

        $reviews = $this->model
            ->select('product_reviews.*, users.username')
            ->join('users', 'users.id = product_reviews.user_id')
            ->where('product_id', $productId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->respond([
            'status' => true,
            'message' => 'Review ditemukan.',
            'data' => $reviews
        ]);
    }

    // ✅ Simpan review
    public function create()
    {
        $user = session()->get();

        if (!$user || empty($user['isLoggedIn'])) {
            return $this->failUnauthorized('Harap login untuk memberi ulasan.');
        }

        $data = $this->request->getJSON(true); // from JSON body

        if (!isset($data['product_id']) || !isset($data['rating'])) {
            return $this->fail('Product ID dan rating wajib diisi.');
        }

        $review = [
            'product_id' => $data['product_id'],
            'user_id'    => $user['user_id'],
            'rating'     => $data['rating'],
            'comment'    => $data['comment'] ?? null
        ];

        if (!$this->model->insert($review)) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated([
            'status' => true,
            'message' => 'Review berhasil ditambahkan.'
        ]);
    }

    // ✅ Produk dengan rating tertinggi
    public function topRated()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('product_reviews');
        $builder->select('product_id, AVG(rating) as avg_rating, COUNT(*) as total_reviews');
        $builder->groupBy('product_id');
        $builder->orderBy('avg_rating', 'DESC');
        $builder->limit(4); // Ambil 4 produk teratas

        $ratings = $builder->get()->getResult();

        // Ambil data produk lengkapnya
        $products = [];
        $productModel = new \App\Models\ProductModel();

        foreach ($ratings as $r) {
            $product = $productModel->find($r->product_id); // hasilnya array
            if ($product) {
                $product['avg_rating'] = round($r->avg_rating, 1);
                $product['total_reviews'] = $r->total_reviews;
                $products[] = $product;
            }
        }

        return $this->respond([
            'status' => true,
            'message' => 'Produk dengan rating tertinggi.',
            'data' => $products
        ]);
    }
}
