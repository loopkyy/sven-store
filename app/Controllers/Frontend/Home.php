<?php
// File: app/Controllers/Frontend/Home.php
namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        // Ambil produk terlaris (kamu pilih manual via is_best_seller = 1)
        $bestSellers = $productModel
            ->where('is_active', 1)
            ->where('is_best_seller', 1)
            ->findAll(4); // ambil maksimal 4 produk

        return view('Frontend/home', [
            'bestSellers' => $bestSellers
        ]);
    }
}
