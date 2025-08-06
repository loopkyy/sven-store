<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductApi extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $category = $this->request->getGet('category');
        $sort     = $this->request->getGet('sort');

        $productModel->where('is_active', 1);

        if ($category) {
            $productModel->where('category_id', $category);
        }

        if ($sort === 'price_asc') {
            $productModel->orderBy('price', 'ASC');
        } elseif ($sort === 'price_desc') {
            $productModel->orderBy('price', 'DESC');
        } elseif ($sort === 'popular') {
            $productModel->orderBy('sold', 'DESC');
        }

        $products = $productModel->paginate(10, 'product');
        $pager    = $productModel->pager;

        return $this->respond([
            'products'   => $products,
            'pager'      => [
                'currentPage' => $pager->getCurrentPage('product'),
                'totalPages'  => $pager->getPageCount('product'),
                'hasNext'     => $pager->hasNextPage('product'),
                'hasPrev'     => $pager->hasPreviousPage('product'),
            ]
        ]);
    }

    public function getBySlug($slug)
    {
        $productModel = new ProductModel();

        $product = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.slug', $slug)
            ->first();

        if (!$product) {
            return $this->failNotFound("Produk tidak ditemukan.");
        }

        $relatedProducts = (new ProductModel())
            ->where('category_id', $product['category_id'])
            ->where('id !=', $product['id'])
            ->where('is_active', 1)
            ->limit(4)
            ->find();

        return $this->respond([
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function category($slug)
    {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();

        $category = $categoryModel->where('slug', $slug)->first();
        if (!$category) {
            return $this->failNotFound("Kategori tidak ditemukan.");
        }

        $products = $productModel
            ->where('category_id', $category['id'])
            ->where('is_active', 1)
            ->paginate(10, 'product');

        $pager = $productModel->pager;

        return $this->respond([
            'category' => $category,
            'products' => $products,
            'pager'    => [
                'currentPage' => $pager->getCurrentPage('product'),
                'totalPages'  => $pager->getPageCount('product'),
            ]
        ]);
    }

    public function bestSeller()
    {
        $productModel = new ProductModel();

        $products = $productModel
            ->where('is_best_seller', 1)
            ->where('is_active', 1)
            ->findAll(4);

        return $this->respond([
            'products' => $products
        ]);
    }
}
