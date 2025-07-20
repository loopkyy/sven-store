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

// ========================
// FRONTEND
// ========================
else {
    $routes->setDefaultNamespace('App\Controllers\Frontend');
    $routes->setDefaultController('Home');
    $routes->setDefaultMethod('index');

 $routes->group('', ['namespace' => 'App\Controllers\Frontend'], function ($routes) {
    // Home
    $routes->get('/', 'Home::index');

    // Produk
$routes->get('produk', 'ProductController::index');
$routes->get('produk/kategori/(:segment)', 'ProductController::category/$1');
$routes->get('produk/(:segment)', 'ProductController::detail/$1');            

    // Wishlist
    $routes->get('wishlist', 'WishlistController::index');
    $routes->get('wishlist/add/(:num)', 'WishlistController::add/$1');
    $routes->get('wishlist/remove/(:num)', 'WishlistController::remove/$1');

    // Cart
$routes->get('cart', 'CartController::index');
$routes->get('cart/add/(:segment)', 'CartController::add/$1');
$routes->post('cart/add', 'CartController::add'); // ✅ Ini aja cukup

$routes->get('cart/remove/(:segment)', 'CartController::remove/$1');
$routes->post('cart/update-quantity/(:segment)', 'CartController::updateQuantity/$1');
$routes->get('cart/clear', 'CartController::clear');

$routes->get('/akun', 'AccountController::index', ['filter' => 'auth']);

$routes->post('newsletter/subscribe', 'NewsletterController::subscribe');

$routes->get('login', 'AuthController::showLogin');
    $routes->post('login', 'AuthController::login');
    $routes->get('register', 'AuthController::showRegister');
    $routes->post('register', 'AuthController::register');
    $routes->get('logout', 'AuthController::logout');
$routes->post('checkout/direct', 'CheckoutController::direct');
    $routes->get('checkout', 'CheckoutController::index', ['filter' => 'auth']);
    $routes->post('checkout/process', 'CheckoutController::process', ['filter' => 'auth']);
});

}

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
