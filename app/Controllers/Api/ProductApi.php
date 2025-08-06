<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductApi extends BaseController
{
    use ResponseTrait;

    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // ✅ GET /api/products
public function index()
{
    $categorySlug = $this->request->getGet('category_slug'); // dari frontend
    $sort         = $this->request->getGet('sort');

    $this->productModel->where('is_active', 1);

    // Jika ada slug kategori, ambil ID-nya dulu
    if ($categorySlug) {
        $category = $this->categoryModel->where('slug', $categorySlug)->first();
        if ($category) {
            $this->productModel->where('category_id', $category['id']);
        } else {
            // Kategori tidak ditemukan, return produk kosong
            return $this->respond([
                'status'   => true,
                'products' => [],
            ]);
        }
    }

    // Sorting
    if ($sort === 'price_asc') {
        $this->productModel->orderBy('price', 'ASC');
    } elseif ($sort === 'price_desc') {
        $this->productModel->orderBy('price', 'DESC');
    } elseif ($sort === 'popular') {
        $this->productModel->orderBy('sold', 'DESC');
    }

    $products = $this->productModel->findAll();

    // Tambahkan image_url
    foreach ($products as &$product) {
        $product['image_url'] = base_url('uploads/' . $product['image']);
    }

    return $this->respond([
        'status'   => true,
        'products' => $products,
    ]);
}


    // ✅ GET /api/products/category/{slug}
    public function category($slug)
    {
        $category = $this->categoryModel->where('slug', $slug)->first();
        if (!$category) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        $products = $this->productModel
            ->where('category_id', $category['id'])
            ->where('is_active', 1)
            ->findAll();
            foreach ($products as &$product) {
    $product['image_url'] = base_url('uploads/' . $product['image']);
}


        return $this->respond([
            'status'   => true,
            'category' => $category,
            'products' => $products,
        ]);
    }

    // ✅ GET /api/products/slug/{slug}
    public function getBySlug($slug)
    {
        $product = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.slug', $slug)
            ->first();

        if (!$product) {
            return $this->failNotFound('Produk tidak ditemukan');
        }

        $relatedProducts = $this->productModel
            ->where('category_id', $product['category_id'])
            ->where('id !=', $product['id'])
            ->where('is_active', 1)
            ->limit(4)
            ->find();
            $product['image_url'] = base_url('uploads/' . $product['image']);

foreach ($relatedProducts as &$item) {
    $item['image_url'] = base_url('uploads/' . $item['image']);
}


        return $this->respond([
            'status'          => true,
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    // ✅ GET /api/products/best-seller
    public function bestSeller()
    {
        $products = $this->productModel
            ->where('is_best_seller', 1)
            ->where('is_active', 1)
            ->findAll(4);
            foreach ($products as &$product) {
    $product['image_url'] = base_url('uploads/' . $product['image']);
}


        return $this->respond([
            'status'   => true,
            'products' => $products,
        ]);
    }
}
