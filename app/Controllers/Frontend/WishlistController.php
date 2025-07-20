<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class WishlistController extends BaseController
{
    public function index()
    {
        $wishlist = session()->get('wishlist') ?? [];
        $productModel = new ProductModel();
        $products = [];

        if (!empty($wishlist)) {
            $products = $productModel
                ->whereIn('id', $wishlist)
                ->where('is_active', 1)
                ->findAll();
        }

        return view('Frontend/Wishlist/index', [
            'products' => $products
        ]);
    }

    public function add($id)
    {
        $wishlist = session()->get('wishlist') ?? [];
        if (!in_array($id, $wishlist)) {
            $wishlist[] = $id;
        }
        session()->set('wishlist', $wishlist);

        return redirect()->back()->with('success', 'Produk ditambahkan ke wishlist.');
    }

    public function remove($id)
    {
        $wishlist = session()->get('wishlist') ?? [];
        $wishlist = array_filter($wishlist, fn($item) => $item != $id);
        session()->set('wishlist', $wishlist);

        return redirect()->back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
