<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ContactModel;
use App\Models\ActivityLogModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);


        // Hanya untuk non-CLI (web)
        if (!is_cli()) {
            // Panggil helper
            helper('setting');

            // Notifikasi pesanan baru
            $orderModel = new OrderModel();
            $newOrderCount = $orderModel->where('status', 'pending')->countAllResults();

            // Notifikasi pesan masuk
            $contactModel = new ContactModel();
            $newContactCount = $contactModel->where('status', 'unread')->countAllResults();

            // Ambil logo dari setting
            $logo = get_setting('site_logo');
            $logoPath = ($logo && file_exists(FCPATH . 'uploads/' . $logo))
                ? base_url('uploads/' . $logo)
                : base_url('assets/img/default-logo.png');
// Hitung jumlah wishlist (jika session tersedia dan di frontend)
$wishlistCount = 0;
if (!is_cli() && session()->has('wishlist')) {
    $wishlist = session('wishlist');
    if (is_array($wishlist)) {
        $wishlistCount = count($wishlist);
    }
}
// Hitung jumlah item di keranjang (cart)
$cartCount = 0;
if (!is_cli() && session()->has('cart')) {
    $cart = session('cart');
    if (is_array($cart)) {
        $cartCount = count($cart);
    }
}

// Bagikan ke semua view
service('renderer')->setData([
    'newOrderCount'   => $newOrderCount,
    'newContactCount' => $newContactCount,
    'logoPath'        => $logoPath,
    'wishlist_count'  => $wishlistCount,
    'cart_count'      => $cartCount
]);

        }
    }

    /**
     * Mencatat aktivitas admin
     */
    protected function logActivity(string $message): void
    {
        $logModel = new ActivityLogModel();
        $logModel->insert([
            'user_id'  => session('user_id') ?? 0,
            'activity' => $message,
        ]);
    }
}
