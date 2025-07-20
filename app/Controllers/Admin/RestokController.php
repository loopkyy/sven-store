<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class RestokController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->orderBy('stock', 'ASC')->findAll();

        return view('admin/restok/index', ['products' => $products]);
    }

    public function tambah($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/restok')->with('error', 'Produk tidak ditemukan');
        }

        return view('admin/restok/tambah', ['product' => $product]);
    }

    public function simpan($id)
    {
        $jumlah = (int) $this->request->getPost('jumlah');
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/restok')->with('error', 'Produk tidak ditemukan');
        }

        $stokBaru = $product['stock'] + $jumlah;
        $this->productModel->update($id, ['stock' => $stokBaru]);

        // Log aktivitas jika tersedia
        if (function_exists('log_activity')) {
            log_activity("Restok produk: {$product['name']} sebanyak {$jumlah} unit (Stok sekarang: {$stokBaru})");
        }

        return redirect()->to('/admin/restok')->with('success', 'Stok berhasil ditambahkan');
    }
}
