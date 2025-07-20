<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\ProductModel;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $orderModel   = new OrderModel();
        $db           = \Config\Database::connect();

        // Ambil filter tanggal dari GET (untuk grafik)
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));
        $endDate   = $this->request->getGet('end_date') ?? date('Y-m-d');

        // Statistik utama
        $totalProduk     = $productModel->countAll();
        $totalOrder      = $orderModel->where('status', 'paid')->countAllResults();
        $totalPendapatan = $orderModel->selectSum('total')->where('status', 'paid')->first()['total'] ?? 0;
        $belumDikirim    = $orderModel->where('shipping_status', 'belum dikirim')->countAllResults();
        $pendingOrders = $orderModel->where('status', 'pending')->countAllResults();


        // Produk dengan stok rendah
        $lowStockProducts = $productModel
            ->where('stock >', 0)
            ->where('stock <=', 5)
            ->orderBy('stock', 'ASC')
            ->findAll();

        // Total pelanggan aktif
        $totalPelangganAktif = $db->table('users')
            ->where('role', 'customer')
            ->where('is_active', 1)
            ->countAllResults();

        // Produk terlaris
        $topProducts = $db->table('order_items')
            ->select('products.name, SUM(order_items.quantity) as total_sold')
            ->join('products', 'products.id = order_items.product_id')
            ->groupBy('order_items.product_id')
            ->orderBy('total_sold', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // Grafik penjualan harian
        $grafikPenjualan = $db->table('orders')
            ->select("DATE(created_at) as tanggal, SUM(total) as total")
            ->where('status', 'paid')
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->groupBy('DATE(created_at)')
            ->orderBy('tanggal', 'ASC')
            ->get()
            ->getResult();

        // ========== Tren Pendapatan ==========
        $pendapatanMingguIni = $orderModel->selectSum('total')
            ->where('status', 'paid')
            ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
            ->first()['total'] ?? 0;

        $pendapatanMingguLalu = $orderModel->selectSum('total')
            ->where('status', 'paid')
            ->where('created_at >=', date('Y-m-d', strtotime('-14 days')))
            ->where('created_at <', date('Y-m-d', strtotime('-7 days')))
            ->first()['total'] ?? 0;

        $trenPendapatan = 'equal';
        if ($pendapatanMingguIni > $pendapatanMingguLalu) {
            $trenPendapatan = 'up';
        } elseif ($pendapatanMingguIni < $pendapatanMingguLalu) {
            $trenPendapatan = 'down';
        }

        // ========== Tren Order ==========
        $orderMingguIni = $orderModel->where('status', 'paid')
            ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
            ->countAllResults();

        $orderMingguLalu = $orderModel->where('status', 'paid')
            ->where('created_at >=', date('Y-m-d', strtotime('-14 days')))
            ->where('created_at <', date('Y-m-d', strtotime('-7 days')))
            ->countAllResults();

        $trenOrder = 'equal';
        if ($orderMingguIni > $orderMingguLalu) {
            $trenOrder = 'up';
        } elseif ($orderMingguIni < $orderMingguLalu) {
            $trenOrder = 'down';
        }

        // ========== Pelanggan Baru ==========
        $pelangganBaruMingguIni = $db->table('users')
            ->where('role', 'customer')
            ->where('DATE(created_at) >=', date('Y-m-d', strtotime('-7 days')))
            ->countAllResults();

        $pelangganBaruMingguLalu = $db->table('users')
            ->where('role', 'customer')
            ->where('DATE(created_at) >=', date('Y-m-d', strtotime('-14 days')))
            ->where('DATE(created_at) <', date('Y-m-d', strtotime('-7 days')))
            ->countAllResults();

        $trenPelanggan = 'equal';
        if ($pelangganBaruMingguIni > $pelangganBaruMingguLalu) {
            $trenPelanggan = 'up';
        } elseif ($pelangganBaruMingguIni < $pelangganBaruMingguLalu) {
            $trenPelanggan = 'down';
        }

        // Kirim ke view
        return view('admin/dashboard/index', [
            'totalProduk'             => $totalProduk,
            'totalOrder'              => $totalOrder,
            'totalPendapatan'         => $totalPendapatan,
            'belumDikirim'            => $belumDikirim,
             'pendingOrders'           => $pendingOrders,
            'lowStockProducts'        => $lowStockProducts,
            'totalPelangganAktif'     => $totalPelangganAktif,
            'topProducts'             => $topProducts,
            'grafikPenjualan'         => $grafikPenjualan,
            'startDate'               => $startDate,
            'endDate'                 => $endDate,
            'pendapatanMingguIni'     => $pendapatanMingguIni,
            'pendapatanMingguLalu'    => $pendapatanMingguLalu,
            'trenPendapatan'          => $trenPendapatan,
            'orderMingguIni'          => $orderMingguIni,
            'orderMingguLalu'         => $orderMingguLalu,
            'trenOrder'               => $trenOrder,
            'pelangganBaruMingguIni'  => $pelangganBaruMingguIni,
            'pelangganBaruMingguLalu' => $pelangganBaruMingguLalu,
            'trenPelanggan'           => $trenPelanggan,
        ]);
    }
}
