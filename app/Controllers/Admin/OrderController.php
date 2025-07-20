<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use App\Models\ActivityLogModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Midtrans\Config;
use Midtrans\Transaction;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $itemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->itemModel  = new OrderItemModel();
    }

    protected function logActivity(string $message): void
    {
        $logModel = new ActivityLogModel();
        $logModel->insert([
            'user_id'  => session('user_id') ?? 0,
            'activity' => $message,
        ]);
    }

    public function index()
    {
        $filterStatus   = $this->request->getGet('status');
        $filterShipping = $this->request->getGet('shipping_status');

        $query = $this->orderModel
            ->select('orders.*, users.username as user_name, payment_methods.name as payment_method_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->join('payment_methods', 'payment_methods.id = orders.payment_method_id', 'left');

        if ($filterStatus) {
            $query->where('orders.status', $filterStatus);
        }

        if ($filterShipping) {
            $query->where('orders.shipping_status', $filterShipping);
        }

        $orders = $query->findAll();

        return view('admin/pesanan/index', [
            'orders' => $orders,
            'filterStatus' => $filterStatus,
            'filterShipping' => $filterShipping,
        ]);
    }

    public function detail($id)
    {
        $order = $this->orderModel
            ->select('orders.*, users.username as user_name, payment_methods.name as payment_method_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->join('payment_methods', 'payment_methods.id = orders.payment_method_id', 'left')
            ->where('orders.id', $id)
            ->first();

        $items = $this->itemModel
            ->select('order_items.*, products.name as product_name')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_items.order_id', $id)
            ->findAll();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('admin/pesanan/detail', [
            'order' => $order,
            'items' => $items,
        ]);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $validStatuses = ['pending', 'paid', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $order = $this->orderModel->find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order['status'] !== 'paid' && $status === 'paid') {
            $items = $this->itemModel->where('order_id', $id)->findAll();
            $productModel = new ProductModel();

            foreach ($items as $item) {
                $product = $productModel->find($item['product_id']);
                if ($product) {
                    $newStock = $product['stock'] - $item['quantity'];
                    $productModel->update($product['id'], [
                        'stock' => max(0, $newStock)
                    ]);
                }
            }
        }

        $this->orderModel->update($id, ['status' => $status]);
        $this->logActivity("Mengubah status pesanan ID $id menjadi $status");
        return redirect()->to('/admin/pesanan')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updateShippingStatus($id)
    {
        $status = $this->request->getPost('shipping_status');
        $validStatuses = ['belum dikirim', 'dikirim', 'diterima'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Status pengiriman tidak valid.');
        }

        $this->orderModel->update($id, ['shipping_status' => $status]);
        $this->logActivity("Mengubah status pengiriman pesanan ID $id menjadi $status");
        return redirect()->to('/admin/pesanan')->with('success', 'Status pengiriman diperbarui.');
    }

    public function invoice($id)
    {
        $order = $this->orderModel
            ->select('orders.*, users.username, payment_methods.name as payment_method_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->join('payment_methods', 'payment_methods.id = orders.payment_method_id', 'left')
            ->where('orders.id', $id)
            ->first();

        $items = $this->itemModel
            ->select('order_items.*, products.name as product_name')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_items.order_id', $id)
            ->findAll();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $html = view('admin/pesanan/invoice', [
            'order' => $order,
            'items' => $items,
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Invoice-Order-{$order['id']}.pdf", ['Attachment' => false]);
    }

    public function pendingCount()
    {
        $count = $this->orderModel
            ->where('status', 'pending')
            ->countAllResults();

        return $this->response->setJSON(['count' => $count]);
    }

    public function checkMidtransStatus($orderId)
    {
        try {
            Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
            Config::$isProduction = getenv('MIDTRANS_IS_PRODUCTION') === 'true';

            $status = Transaction::status($orderId);
            return $this->response->setJSON($status);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }
}
