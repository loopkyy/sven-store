<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;

class LaporanController extends BaseController
{
    protected $orderModel;
    protected $itemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->itemModel  = new OrderItemModel();
    }

    public function index()
    {
        $from = $this->request->getGet('from');
        $to   = $this->request->getGet('to');

        $query = $this->orderModel
            ->select('orders.*, users.username as user_name')
            ->join('users', 'users.id = orders.user_id', 'left');

        if ($from && $to) {
            if (!Time::createFromFormat('Y-m-d', $from) || !Time::createFromFormat('Y-m-d', $to)) {
                return redirect()->to('/admin/laporan')->with('error', 'Format tanggal tidak valid.');
            }

            $query->where('orders.created_at >=', $from . ' 00:00:00')
                  ->where('orders.created_at <=', $to . ' 23:59:59');
        }

        $orders = $query->orderBy('orders.created_at', 'ASC')->findAll();

        // Grafik Penjualan
        $grafikQuery = $this->orderModel
            ->select("DATE(created_at) as date, SUM(total) as total")
            ->groupBy("DATE(created_at)")
            ->orderBy("date", "ASC");

        if ($from && $to) {
            $grafikQuery->where('created_at >=', $from . ' 00:00:00')
                        ->where('created_at <=', $to . ' 23:59:59');
        }

        $grafik = $grafikQuery->findAll();

        return view('admin/laporan/index', [
            'orders'      => $orders,
            'chartLabels' => array_column($grafik, 'date'),
            'chartData'   => array_map('intval', array_column($grafik, 'total')),
            'from'        => $from,
            'to'          => $to,
        ]);
    }

    public function harian()
    {
        $today = date('Y-m-d');

        $orders = $this->orderModel
            ->where('DATE(created_at)', $today)
            ->findAll();

        return view('admin/laporan/harian', ['orders' => $orders, 'tanggal' => $today]);
    }

    public function bulanan()
    {
        $bulanIni = date('Y-m');

        $orders = $this->orderModel
            ->where('DATE_FORMAT(created_at, "%Y-%m")', $bulanIni)
            ->findAll();

        return view('admin/laporan/bulanan', ['orders' => $orders, 'bulan' => $bulanIni]);
    }

    public function semua()
    {
        $orders = $this->orderModel->findAll();

        return view('admin/laporan/semua', ['orders' => $orders]);
    }

    public function exportPdf()
    {
        $from = $this->request->getGet('from');
        $to   = $this->request->getGet('to');

        $query = $this->orderModel
            ->select('orders.*, users.username as user_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'ASC');

        if ($from && $to) {
            $query->where('orders.created_at >=', $from . ' 00:00:00')
                  ->where('orders.created_at <=', $to . ' 23:59:59');
        }

        $orders = $query->findAll();

        foreach ($orders as &$order) {
            $order['items'] = $this->itemModel
                ->select('order_items.*, products.name as product_name')
                ->join('products', 'products.id = order_items.product_id', 'left')
                ->where('order_items.order_id', $order['id'])
                ->findAll();
        }

        $html = view('admin/laporan/pdf', ['orders' => $orders, 'from' => $from, 'to' => $to]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("laporan_penjualan.pdf", ["Attachment" => true]);
        exit;
    }

    public function exportExcel()
    {
        $from = $this->request->getGet('from');
        $to   = $this->request->getGet('to');

        $query = $this->orderModel
            ->select('orders.*, users.username as user_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'ASC');

        if ($from && $to) {
            $query->where('orders.created_at >=', $from . ' 00:00:00')
                  ->where('orders.created_at <=', $to . ' 23:59:59');
        }

        $orders = $query->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Penjualan');

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama User');
        $sheet->setCellValue('C1', 'Total');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Tanggal');

        $row = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue("A{$row}", $order['id']);
            $sheet->setCellValue("B{$row}", $order['user_name']);
            $sheet->setCellValue("C{$row}", $order['total']);
            $sheet->setCellValue("D{$row}", ucfirst($order['status']));
            $sheet->setCellValue("E{$row}", $order['created_at']);
            $row++;

            $items = $this->itemModel
                ->select('order_items.*, products.name as product_name')
                ->join('products', 'products.id = order_items.product_id', 'left')
                ->where('order_items.order_id', $order['id'])
                ->findAll();

            if (!empty($items)) {
                $sheet->setCellValue("B{$row}", '  └ Detail Item:');
                $row++;
                $sheet->setCellValue("B{$row}", 'Produk');
                $sheet->setCellValue("C{$row}", 'Harga');
                $sheet->setCellValue("D{$row}", 'Qty');
                $sheet->setCellValue("E{$row}", 'Subtotal');
                $row++;

                foreach ($items as $item) {
                    $sheet->setCellValue("B{$row}", $item['product_name']);
                    $sheet->setCellValue("C{$row}", $item['price']);
                    $sheet->setCellValue("D{$row}", $item['quantity']);
                    $sheet->setCellValue("E{$row}", $item['subtotal']);
                    $row++;
                }
            }
        }

        $filename = 'Laporan_Penjualan_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
