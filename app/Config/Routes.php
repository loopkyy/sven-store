<?php

use CodeIgniter\Router\RouteCollection;
use Config\Services;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

// General
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// Deteksi domain
$host = $_SERVER['HTTP_HOST'] ?? '';

// ========================
// ADMIN PANEL
// ========================
if (str_contains($host, 'admin-lunaya.test')) {
    $routes->setDefaultNamespace('App\Controllers\Admin');
    $routes->setDefaultController('Dashboard');
    $routes->setDefaultMethod('index');

    // AUTH
    $routes->get('/', 'Dashboard::index');
    $routes->get('admin/login', 'LoginController::index');
    $routes->post('admin/login/authenticate', 'LoginController::authenticate');
    $routes->get('admin/logout', 'LoginController::logout');

    // PANEL ADMIN
    $routes->group('admin', function ($routes) {
        $routes->get('dashboard', 'Dashboard::index');

        // Produk
        $routes->get('produk', 'ProductController::index');
        $routes->get('produk/create', 'ProductController::create');
        $routes->post('produk/store', 'ProductController::store');
        $routes->get('produk/edit/(:num)', 'ProductController::edit/$1');
        $routes->post('produk/update/(:num)', 'ProductController::update/$1');
        $routes->post('produk/delete/(:num)', 'ProductController::delete/$1');
        $routes->get('produk/import', 'ProductController::importForm');
        $routes->post('produk/import', 'ProductController::importExcel');
        $routes->post('produk/upload-image/(:num)', 'ProductController::uploadImage/$1');
        $routes->post('produk/delete-all', 'ProductController::deleteAll');

        // Kategori
        $routes->get('kategori', 'CategoryController::index');
        $routes->get('kategori/create', 'CategoryController::create');
        $routes->post('kategori/store', 'CategoryController::store');
        $routes->get('kategori/edit/(:num)', 'CategoryController::edit/$1');
        $routes->post('kategori/update/(:num)', 'CategoryController::update/$1');
        $routes->get('kategori/delete/(:num)', 'CategoryController::delete/$1');

        // Pesanan
        $routes->get('pesanan', 'OrderController::index');
        $routes->get('pesanan/detail/(:num)', 'OrderController::detail/$1');
        $routes->post('pesanan/update-status/(:num)', 'OrderController::updateStatus/$1');
        $routes->get('pesanan/invoice/(:num)', 'OrderController::invoice/$1');
        $routes->post('pesanan/update-shipping/(:num)', 'OrderController::updateShippingStatus/$1');
        $routes->get('api/orders/pending-count', 'OrderController::pendingCount');

        // Restok
        $routes->get('restok', 'RestokController::index');
        $routes->get('restok/tambah/(:num)', 'RestokController::tambah/$1');
        $routes->post('restok/simpan/(:num)', 'RestokController::simpan/$1');

        // Retur
        $routes->get('retur', 'ReturnController::index');
        $routes->get('retur/create', 'ReturnController::create');
        $routes->post('retur/store', 'ReturnController::store');
        $routes->post('retur/update-status/(:num)', 'ReturnController::updateStatus/$1');
        $routes->get('retur/edit/(:num)', 'ReturnController::edit/$1');
        $routes->post('retur/update/(:num)', 'ReturnController::update/$1');
        $routes->get('retur/delete/(:num)', 'ReturnController::delete/$1');
        $routes->get('retur/export-pdf', 'ReturnController::exportPdf');
        $routes->get('retur/export-excel', 'ReturnController::exportExcel');

        // Kupon
        $routes->get('kupon', 'CouponController::index');
        $routes->get('kupon/create', 'CouponController::create');
        $routes->post('kupon/store', 'CouponController::store');
        $routes->get('kupon/edit/(:num)', 'CouponController::edit/$1');
        $routes->post('kupon/update/(:num)', 'CouponController::update/$1');
        $routes->get('kupon/delete/(:num)', 'CouponController::delete/$1');
        $routes->get('kupon/export-pdf', 'CouponController::exportPdf');
        $routes->get('kupon/export-excel', 'CouponController::exportExcel');
        $routes->get('kupon/toggle/(:num)', 'CouponController::toggle/$1');

        // Pembayaran
        $routes->get('pembayaran', 'PaymentController::index');
        $routes->get('pembayaran/create', 'PaymentController::create');
        $routes->post('pembayaran/store', 'PaymentController::store');
        $routes->get('pembayaran/edit/(:num)', 'PaymentController::edit/$1');
        $routes->post('pembayaran/update/(:num)', 'PaymentController::update/$1');
        $routes->post('pembayaran/delete/(:num)', 'PaymentController::delete/$1');

        // Laporan
        $routes->get('laporan', 'LaporanController::index');
        $routes->get('laporan/harian', 'LaporanController::harian');
        $routes->get('laporan/bulanan', 'LaporanController::bulanan');
        $routes->get('laporan/semua', 'LaporanController::semua');
        $routes->get('laporan/export-pdf', 'LaporanController::exportPdf');
        $routes->get('laporan/export-excel', 'LaporanController::exportExcel');
        $routes->get('laporan-mingguan/export', 'LaporanMingguan::export');

        // Pelanggan
        $routes->get('pelanggan', 'CustomerController::index');
        $routes->get('pelanggan/edit/(:num)', 'CustomerController::edit/$1');
        $routes->post('pelanggan/update/(:num)', 'CustomerController::update/$1');
        $routes->post('pelanggan/delete/(:num)', 'CustomerController::delete/$1');
        $routes->get('pelanggan/detail/(:num)', 'CustomerController::detail/$1');
        $routes->get('pelanggan/toggle/(:num)', 'CustomerController::toggleStatus/$1');

        // Kontak
        $routes->get('kontak', 'ContactController::index');
        $routes->get('kontak/delete/(:num)', 'ContactController::delete/$1');
        $routes->get('kontak/mark-read/(:num)', 'ContactController::markRead/$1');
        $routes->get('kontak/unread-count', 'ContactController::unreadCount');

        // Newsletter
        $routes->get('newsletter', 'NewsletterController::index');
        $routes->get('newsletter/delete/(:num)', 'NewsletterController::delete/$1');
        $routes->get('newsletter/toggle/(:num)', 'NewsletterController::toggle/$1');
        $routes->get('newsletter/export-pdf', 'NewsletterController::exportPdf');
        $routes->get('newsletter/export-excel', 'NewsletterController::exportExcel');
        $routes->get('newsletter/kirim', 'NewsletterController::kirim');
        $routes->post('newsletter/send', 'NewsletterController::prosesKirim');
    });

    // SUPERADMIN
    $routes->group('superadmin', [
        'namespace' => 'App\Controllers\Superadmin',
        'filter' => 'role:superadmin'
    ], function ($routes) {
        $routes->get('/', 'AdminController::index');
        $routes->get('create', 'AdminController::create');
        $routes->post('store', 'AdminController::store');
        $routes->get('edit/(:num)', 'AdminController::edit/$1');
        $routes->post('update/(:num)', 'AdminController::update/$1');
        $routes->get('delete/(:num)', 'AdminController::delete/$1');
        $routes->get('toggle/(:num)', 'AdminController::toggle/$1');

        $routes->get('log', 'ActivityLogController::index');
        $routes->post('log/delete/(:num)', 'ActivityLogController::delete/$1');
        $routes->post('log/delete-all', 'ActivityLogController::deleteAll');

        $routes->get('pengaturan', 'SettingController::index');
        $routes->post('pengaturan/save', 'SettingController::save');
        $routes->post('pengaturan/maintenance', 'SettingController::maintenance');
        $routes->post('pengaturan/upload-logo', 'SettingController::uploadLogo');
        $routes->post('pengaturan/upload-favicon', 'SettingController::uploadFavicon');
    });
}

else {
    // DEFAULT NAMESPACE UNTUK FRONTEND/API
    $routes->setDefaultNamespace('App\Controllers');
    $routes->setDefaultController('Home'); // WAJIB diisi
    $routes->setDefaultMethod('index');
    $routes->options('(:any)', function() {
    return service('response')->setStatusCode(200);
});

  $routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    // Produk
    $routes->get('products', 'ProductApi::index');
    $routes->get('products/slug/(:segment)', 'ProductApi::getBySlug/$1');
    $routes->get('products/category/(:segment)', 'ProductApi::category/$1');
    $routes->get('products/best-seller', 'ProductApi::bestSeller');

    // Cart
$routes->get('cart', 'CartApi::index');
$routes->post('cart/add', 'CartApi::add');
$routes->post('cart/update', 'CartApi::update');
$routes->get('cart/clear', 'CartApi::clear');
$routes->get('cart/count', 'CartApi::count');
$routes->post('cart/remove', 'CartApi::removePost');



    // Checkout
    $routes->post('checkout', 'CheckoutApi::process');

    // wishlist
$routes->get('wishlist', 'WishlistApi::index');
$routes->post('wishlist/add', 'WishlistApi::add');
$routes->post('wishlist/remove', 'WishlistApi::remove');
$routes->get('wishlist/clear', 'WishlistApi::clear');
$routes->get('wishlist/count', 'WishlistApi::count');

    // Auth
    $routes->post('auth/register', 'AuthApi::register');
    $routes->post('auth/login', 'AuthApi::login');
    $routes->post('auth/logout', 'AuthApi::logout');

    // Account
    $routes->get('account', 'AccountApi::profile');
    $routes->put('account/update', 'AccountApi::updateProfile');
    $routes->put('account/change-password', 'AccountApi::changePassword');
    $routes->post('account/avatar', 'AccountApi::uploadAvatar');

    //Orders
      $routes->get('orders/history', 'OrderApi::history');

    // riviw
    $routes->get('reviews/(:num)', 'ProductReviewApi::index/$1');
    $routes->post('reviews', 'ProductReviewApi::create');
    $routes->get('products/top-rated', 'ProductReviewApi::topRated'); 

    
    //shping
    $routes->get('shippings', 'ShippingApi::index');

    //copon
    $routes->post('coupon/validate', 'CouponApi::validateCoupon');
    $routes->get('coupon/active', 'CouponApi::activeCoupons');


    //category
$routes->get('categories', 'CategoryApi::index');
$routes->get('categories/slug/(:segment)', 'CategoryApi::slug/$1'); 
$routes->get('categories/(:segment)', 'CategoryApi::show/$1');


});



    // FRONTEND - Serve HTML dari `public/assets/frontend/`
    $routes->get('/', function () {
        return file_get_contents(FCPATH . 'assets/frontend/index.html');
    });

    $routes->get('produk', function () {
        return file_get_contents(FCPATH . 'assets/frontend/produk.html');
    });

    $routes->get('produk/(:segment)', function () {
        return file_get_contents(FCPATH . 'assets/frontend/detail.html');
    });
}

// ===============================
// 3️⃣ ENV-SPECIFIC ROUTING
// ===============================
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}