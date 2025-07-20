<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\OrderModel;
use App\Models\UserModel;
use CodeIgniter\Database\BaseBuilder;

class WeeklyReportGenerator extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'weekly:generate';
    protected $description = 'Generate weekly report summary';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $orderModel = new OrderModel();
        $userModel = new UserModel();

        $endDate = date('Y-m-d', strtotime('last sunday'));
        $startDate = date('Y-m-d', strtotime('-6 days', strtotime($endDate)));

        CLI::write("Membuat ringkasan untuk: $startDate - $endDate", 'yellow');

        // Cek apakah sudah ada laporan minggu ini
        $exists = $db->table('weekly_reports')
            ->where('start_date', $startDate)
            ->countAllResults();

        if ($exists > 0) {
            CLI::error("Laporan minggu ini sudah ada!");
            return;
        }

        // Total order
        $totalOrder = $orderModel->where('status', 'paid')
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->countAllResults();

        // Total pendapatan
        $totalPendapatan = $orderModel->selectSum('total')
            ->where('status', 'paid')
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->first()['total'] ?? 0;

        // Pelanggan baru
        $pelangganBaru = $userModel->where('role', 'customer')
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->countAllResults();

        // Top products
        $topProducts = $db->table('order_items')
            ->select('products.name, SUM(order_items.quantity) as total_sold')
            ->join('orders', 'orders.id = order_items.order_id')
            ->join('products', 'products.id = order_items.product_id')
            ->where('orders.status', 'paid')
            ->where('DATE(orders.created_at) >=', $startDate)
            ->where('DATE(orders.created_at) <=', $endDate)
            ->groupBy('order_items.product_id')
            ->orderBy('total_sold', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $topProductsJSON = json_encode($topProducts);

        // Simpan ke tabel
        $db->table('weekly_reports')->insert([
            'start_date'       => $startDate,
            'end_date'         => $endDate,
            'total_order'      => $totalOrder,
            'total_pendapatan' => $totalPendapatan,
            'pelanggan_baru'   => $pelangganBaru,
            'top_products'     => $topProductsJSON,
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        CLI::write("✅ Laporan mingguan berhasil disimpan!", 'green');
    }
}
