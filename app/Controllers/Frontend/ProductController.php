<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $category = $this->request->getGet('category');
        $sort     = $this->request->getGet('sort');
        $view     = $this->request->getGet('view');

        $productModel->where('is_active', 1);

        if ($category) {
            $productModel->where('category_id', $category);
        }

        if ($sort === 'price_asc') {
            $productModel->orderBy('price', 'ASC');
        } elseif ($sort === 'price_desc') {
            $productModel->orderBy('price', 'DESC');
        } elseif ($sort === 'popular') {
            $productModel->orderBy('sold', 'DESC'); // jika kolom sold ada
        }

        $products = $productModel->paginate(10, 'product');
        $pager    = $productModel->pager;

        return view('Frontend/Product/index', [
            'products'          => $products,
            'categories'        => $categoryModel->findAll(),
            'selected_category' => $category,
            'selected_sort'     => $sort,
            'selected_view'     => $view ?: 'grid',
            'pager'             => $pager
        ]);
    }

    public function category($categorySlug)
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        // Cari kategori berdasarkan slug
        $category = $categoryModel->where('slug', $categorySlug)->first();
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $products = $productModel
            ->where('category_id', $category['id'])
            ->where('is_active', 1)
            ->paginate(10, 'product');

        $pager = $productModel->pager;

        return view('Frontend/Product/category', [
            'products' => $products,
            'category' => $category,
            'pager'    => $pager
        ]);
    }

public function detail($slug)
{
    $productModel = new ProductModel();

    $product = $productModel
        ->select('products.*, categories.name as category_name')
        ->join('categories', 'categories.id = products.category_id', 'left')
        ->where('products.slug', $slug)
        ->first();

    if (!$product) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Jangan pakai $productModel lagi, bikin baru
    $relatedProducts = (new ProductModel())
        ->where('category_id', $product['category_id'])
        ->where('id !=', $product['id'])
        ->where('is_active', 1)
        ->limit(4)
        ->find();

    return view('Frontend/Product/detail', [
        'product'         => $product,
        'relatedProducts' => $relatedProducts
    ]);
}

    public function bestSeller()
{
    $productModel = new ProductModel();

    $products = $productModel
        ->where('is_best_seller', 1)
        ->where('is_active', 1)
        ->findAll(4); // ambil 4 produk saja

    return $products;
}

}
