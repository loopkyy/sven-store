<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class CategoryApi extends BaseController
{
    public function index()
    {
        $model = new CategoryModel();
        $categories = $model->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    // Endpoint: GET /api/categories/{slug}
    public function show($slug)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        // Cari kategori berdasarkan slug
        $category = $categoryModel->where('slug', $slug)->first();

        if (!$category) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan.'
            ])->setStatusCode(404);
        }

        // Ambil semua produk berdasarkan category_id
        $products = $productModel->where('category_id', $category['id'])->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'category' => $category,
            'products' => $products
        ]);
    }

    // Endpoint: GET /api/categories/slug/{slug}
    public function slug($slug)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->where('slug', $slug)->first();

        if (!$category) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan.'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $category
        ]);
    }
}
